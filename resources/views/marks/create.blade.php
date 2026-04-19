@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-start">
        @include('layouts.left-menu')
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-10 col-xl-10 col-xxl-10">
            <div class="row pt-2">
                <div class="col ps-4">
                    <h1 class="display-6 mb-3">
                        <i class="bi bi-cloud-sun"></i> Give Marks
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{url()->previous()}}">My courses</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Give Marks</li>
                        </ol>
                    </nav>
                    @include('session-messages')

                    @php
                        $writtenExams = [];
                        $performanceExams = [];
                        $quarterlyExams = [];

                        foreach ($exams as $exam) {
                            $examName = strtolower($exam->exam_name);

                            if (str_contains($examName, 'quarterly') || str_contains($examName, 'assessment') || preg_match('/\bqa\b/i', $exam->exam_name)) {
                                $quarterlyExams[] = $exam;
                            } elseif (str_contains($examName, 'performance') || str_contains($examName, 'project') || str_contains($examName, 'task') || preg_match('/\bpt\b/i', $exam->exam_name) || str_contains($examName, 'practical')) {
                                $performanceExams[] = $exam;
                            } else {
                                $writtenExams[] = $exam;
                            }
                        }

                        if (count($quarterlyExams) === 0 && count($exams) > 0) {
                            $lastExam = $exams[count($exams) - 1];
                            $writtenExams = array_values(array_filter($writtenExams, fn ($exam) => $exam->id !== $lastExam->id));
                            $performanceExams = array_values(array_filter($performanceExams, fn ($exam) => $exam->id !== $lastExam->id));
                            $quarterlyExams[] = $lastExam;
                        }

                        $marksByStudentByExam = [];
                        foreach ($students_with_marks as $studentId => $studentMarks) {
                            foreach ($studentMarks as $studentMark) {
                                $marksByStudentByExam[$studentId][$studentMark->exam_id] = $studentMark->marks;
                            }
                        }
                    @endphp

                    @if ($academic_setting['marks_submission_status'] == "on")
                    <p class="text-primary">
                        <i class="bi bi-exclamation-diamond-fill me-2"></i> Marks Submission Window is open now.
                    </p>
                    @endif
                    <p class="text-primary">
                        <i class="bi bi-grid-3x3-gap-fill me-2"></i> DepEd-style encoding enabled: Written Works (40%), Performance Tasks (40%), Quarterly Assessment (20%). PS = Percentage Score, WS = Weighted Score.
                    </p>
                    @if ($final_marks_submitted)
                    <p class="text-success">
                        <i class="bi bi-exclamation-diamond-fill me-2"></i> Marks are submitted.
                    </p>
                    @endif
                    <h3><i class="bi bi-diagram-2"></i> Class #{{request()->query('class_name')}}, Section #{{request()->query('section_name')}}</h3>
                    <h3><i class="bi bi-compass"></i> Course: {{request()->query('course_name')}}</h3>

                    @if (!$final_marks_submitted && count($exams) > 0 && $academic_setting['marks_submission_status'] == "on")
                        <div class="col-3 mt-3">
                            <a type="button" href="{{route('course.final.mark.submit.show', ['class_id' => $class_id, 'class_name' => request()->query('class_name'), 'section_id' => $section_id, 'section_name' => request()->query('section_name'), 'course_id' => $course_id, 'course_name' => request()->query('course_name'), 'semester_id' => $semester_id])}}" class="btn btn-outline-primary" onclick="return confirm('Are you sure, you want to submit final marks?')"><i class="bi bi-check2"></i> Submit Final Marks</a>
                        </div>
                    @endif

                    <form action="{{route('course.mark.store')}}" method="POST">
                        @csrf
                        <input type="hidden" name="session_id" value="{{$current_school_session_id}}">
                        <div class="row mt-3">
                            <div class="col">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered align-middle" id="deped-grading-table">
                                        <thead>
                                            <tr class="table-light">
                                                <th scope="col" rowspan="2" class="text-nowrap">Learner's Name</th>
                                                <th scope="col" colspan="{{max(count($writtenExams), 1) + 3}}" class="text-center">Written Works (40%)</th>
                                                <th scope="col" colspan="{{max(count($performanceExams), 1) + 3}}" class="text-center">Performance Tasks (40%)</th>
                                                <th scope="col" colspan="{{max(count($quarterlyExams), 1) + 2}}" class="text-center">Quarterly Assessment (20%)</th>
                                                <th scope="col" rowspan="2" class="text-nowrap text-center">Initial Grade</th>
                                            </tr>
                                            <tr class="table-light">
                                                @forelse($writtenExams as $exam)
                                                    <th scope="col" class="text-nowrap">{{$exam->exam_name}}</th>
                                                @empty
                                                    <th scope="col" class="text-nowrap">No WW exam</th>
                                                @endforelse
                                                <th scope="col" class="text-center">Total</th>
                                                <th scope="col" class="text-center">PS</th>
                                                <th scope="col" class="text-center">WS</th>

                                                @forelse($performanceExams as $exam)
                                                    <th scope="col" class="text-nowrap">{{$exam->exam_name}}</th>
                                                @empty
                                                    <th scope="col" class="text-nowrap">No PT exam</th>
                                                @endforelse
                                                <th scope="col" class="text-center">Total</th>
                                                <th scope="col" class="text-center">PS</th>
                                                <th scope="col" class="text-center">WS</th>

                                                @forelse($quarterlyExams as $exam)
                                                    <th scope="col" class="text-nowrap">{{$exam->exam_name}}</th>
                                                @empty
                                                    <th scope="col" class="text-nowrap">No QA exam</th>
                                                @endforelse
                                                <th scope="col" class="text-center">PS</th>
                                                <th scope="col" class="text-center">WS</th>
                                            </tr>
                                            <tr>
                                                <th class="text-end small">Highest Possible Score</th>

                                                @forelse($writtenExams as $exam)
                                                    <th><input type="number" min="1" step="0.01" class="form-control form-control-sm hps-input" data-category="written" data-exam-id="{{$exam->id}}" value="100"></th>
                                                @empty
                                                    <th class="text-center text-muted">-</th>
                                                @endforelse
                                                <th></th>
                                                <th class="small text-center">100.00</th>
                                                <th class="small text-center">40%</th>

                                                @forelse($performanceExams as $exam)
                                                    <th><input type="number" min="1" step="0.01" class="form-control form-control-sm hps-input" data-category="performance" data-exam-id="{{$exam->id}}" value="100"></th>
                                                @empty
                                                    <th class="text-center text-muted">-</th>
                                                @endforelse
                                                <th></th>
                                                <th class="small text-center">100.00</th>
                                                <th class="small text-center">40%</th>

                                                @forelse($quarterlyExams as $exam)
                                                    <th><input type="number" min="1" step="0.01" class="form-control form-control-sm hps-input" data-category="quarterly" data-exam-id="{{$exam->id}}" value="100"></th>
                                                @empty
                                                    <th class="text-center text-muted">-</th>
                                                @endforelse
                                                <th class="small text-center">100.00</th>
                                                <th class="small text-center">20%</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sectionStudents as $sectionStudent)
                                                @php
                                                    $student = $sectionStudent->student;
                                                    $studentMarks = $marksByStudentByExam[$student->id] ?? [];
                                                @endphp
                                                <tr>
                                                    <td class="text-nowrap">{{$student->first_name}} {{$student->last_name}}</td>

                                                    @forelse($writtenExams as $exam)
                                                        <td>
                                                            <input type="number" step="0.01" class="form-control score-input" data-category="written" data-exam-id="{{$exam->id}}" name="student_mark[{{$student->id}}][{{$exam->id}}]" value="{{$studentMarks[$exam->id] ?? ''}}">
                                                        </td>
                                                    @empty
                                                        <td class="text-center text-muted">-</td>
                                                    @endforelse
                                                    <td><input type="number" step="0.01" class="form-control total-input" data-category="written" readonly></td>
                                                    <td><input type="number" step="0.01" class="form-control ps-input" data-category="written" readonly></td>
                                                    <td><input type="number" step="0.01" class="form-control ws-input" data-category="written" readonly></td>

                                                    @forelse($performanceExams as $exam)
                                                        <td>
                                                            <input type="number" step="0.01" class="form-control score-input" data-category="performance" data-exam-id="{{$exam->id}}" name="student_mark[{{$student->id}}][{{$exam->id}}]" value="{{$studentMarks[$exam->id] ?? ''}}">
                                                        </td>
                                                    @empty
                                                        <td class="text-center text-muted">-</td>
                                                    @endforelse
                                                    <td><input type="number" step="0.01" class="form-control total-input" data-category="performance" readonly></td>
                                                    <td><input type="number" step="0.01" class="form-control ps-input" data-category="performance" readonly></td>
                                                    <td><input type="number" step="0.01" class="form-control ws-input" data-category="performance" readonly></td>

                                                    @forelse($quarterlyExams as $exam)
                                                        <td>
                                                            <input type="number" step="0.01" class="form-control score-input" data-category="quarterly" data-exam-id="{{$exam->id}}" name="student_mark[{{$student->id}}][{{$exam->id}}]" value="{{$studentMarks[$exam->id] ?? ''}}">
                                                        </td>
                                                    @empty
                                                        <td class="text-center text-muted">-</td>
                                                    @endforelse
                                                    <td><input type="number" step="0.01" class="form-control ps-input" data-category="quarterly" readonly></td>
                                                    <td><input type="number" step="0.01" class="form-control ws-input" data-category="quarterly" readonly></td>

                                                    <td><input type="number" step="0.01" class="form-control initial-grade-input" readonly></td>
                                                </tr>
                                            @endforeach

                                            <input type="hidden" name="studentCount" value="{{count($sectionStudents)}}">
                                            <input type="hidden" name="semester_id" value="{{$semester_id}}">
                                            <input type="hidden" name="class_id" value="{{$class_id}}">
                                            <input type="hidden" name="section_id" value="{{$section_id}}">
                                            <input type="hidden" name="course_id" value="{{$course_id}}">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        @if(!$final_marks_submitted && count($exams) > 0)
                            <div class="col-3">
                                <button type="submit" class="btn btn-outline-primary"><i class="bi bi-check2"></i> Save</button>
                            </div>
                        @else
                            @if($final_marks_submitted)
                                <div class="col-5">
                                    <p class="text-success">
                                        <i class="bi bi-exclamation-diamond-fill me-2"></i> You have submitted Final Marks <i class="bi bi-stars"></i>.
                                    </p>
                                </div>
                            @else
                                <div class="col-5">
                                    <p class="text-primary">
                                        <i class="bi bi-exclamation-diamond-fill me-2"></i> Create Exam to give marks.
                                    </p>
                                </div>
                            @endif
                        @endif
                    </form>
                </div>
            </div>
            @include('layouts.footer')
        </div>
    </div>
</div>
<script>
(function () {
    const categoryWeights = {
        written: 0.40,
        performance: 0.40,
        quarterly: 0.20,
    };

    function toNumber(value) {
        const parsed = parseFloat(value);
        return Number.isFinite(parsed) ? parsed : 0;
    }

    function getCategoryHpsTotal(category) {
        return Array.from(document.querySelectorAll(`.hps-input[data-category="${category}"]`))
            .reduce((sum, input) => sum + Math.max(toNumber(input.value), 0), 0);
    }

    function calculateCategory(row, category) {
        const scoreInputs = row.querySelectorAll(`.score-input[data-category="${category}"]`);
        const total = Array.from(scoreInputs).reduce((sum, input) => sum + Math.max(toNumber(input.value), 0), 0);
        const hpsTotal = getCategoryHpsTotal(category);

        const totalInput = row.querySelector(`.total-input[data-category="${category}"]`);
        const psInput = row.querySelector(`.ps-input[data-category="${category}"]`);
        const wsInput = row.querySelector(`.ws-input[data-category="${category}"]`);

        const ps = hpsTotal > 0 ? (total / hpsTotal) * 100 : 0;
        const ws = ps * categoryWeights[category];

        if (totalInput) {
            totalInput.value = total.toFixed(2);
        }
        if (psInput) {
            psInput.value = ps.toFixed(2);
        }
        if (wsInput) {
            wsInput.value = ws.toFixed(2);
        }

        return ws;
    }

    function calculateRow(row) {
        const writtenWs = calculateCategory(row, 'written');
        const performanceWs = calculateCategory(row, 'performance');
        const quarterlyWs = calculateCategory(row, 'quarterly');
        const initialGradeInput = row.querySelector('.initial-grade-input');

        if (initialGradeInput) {
            initialGradeInput.value = (writtenWs + performanceWs + quarterlyWs).toFixed(2);
        }
    }

    function calculateAllRows() {
        document.querySelectorAll('#deped-grading-table tbody tr').forEach(calculateRow);
    }

    document.querySelectorAll('.score-input').forEach((input) => {
        input.addEventListener('input', (event) => {
            const row = event.target.closest('tr');
            if (row) {
                calculateRow(row);
            }
        });
    });

    document.querySelectorAll('.hps-input').forEach((input) => {
        input.addEventListener('input', calculateAllRows);
    });

    calculateAllRows();
})();
</script>
@endsection
