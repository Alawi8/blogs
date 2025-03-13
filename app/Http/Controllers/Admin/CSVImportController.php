<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\Question;
use App\Models\Answer;
use Maatwebsite\Excel\Facades\Excel;

class CSVImportController extends Controller
{
    public function importQuestions(Request $request)
    {
        $request->validate([
            'test_id' => 'required|exists:tests,id',
            'file' => 'required|mimes:csv,txt'
        ]);

        $file = fopen($request->file('file'), 'r');
        $header = fgetcsv($file); // قراءة الصف الأول (العناوين)

        while ($row = fgetcsv($file)) {
            $question = Question::create([
                'test_id' => $request->test_id,
                'question_text' => $row[0] // العمود الأول للسؤال
            ]);

            // إنشاء الإجابات (العمود 2 و 3 و 4 و 5 للإجابات، العمود 6 للإجابة الصحيحة)
            for ($i = 1; $i <= 4; $i++) {
                if (!empty($row[$i])) {
                    Answer::create([
                        'question_id' => $question->id,
                        'answer_text' => $row[$i],
                        'is_correct' => ($row[5] == $i) ? true : false
                    ]);
                }
            }
        }

        fclose($file);

        return response()->json(['message' => 'تم استيراد الأسئلة بنجاح'], 200);
    }
}
