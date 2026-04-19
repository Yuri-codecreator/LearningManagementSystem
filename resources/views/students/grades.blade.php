@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-start">
        @include('layouts.left-menu')
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-10 col-xl-10 col-xxl-10">
            <div class="row pt-2">
                <div class="col ps-4">
                    <h1 class="display-6 mb-3">
                        <i class="bi bi-journal-check"></i> Student Grades
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{url()->previous()}}">Student List</a></li>
                            <li class="breadcrumb-item active" aria-current="page">View Grade</li>
                        </ol>
                    </nav>

                    @include('session-messages')

                    <h5>Student: {{$student->first_name}} {{$student->last_name}}</h5>

                    <div class="bg-white border shadow-sm p-3 mt-4">
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th scope="col">Semester</th>
                                    <th scope="col">Course</th>
                                    <th scope="col">Teacher Added Marks</th>
                                    <th scope="col">Calculated Marks</th>
                                    <th scope="col">Final Grade (Marks)</th>
                                    <th scope="col">Letter Grade</th>
                                    <th scope="col">Grade Point</th>
                                    <th scope="col">Teacher Note</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($course_performance as $performance)
                                <tr>
                                    <td>{{$performance['semester_name']}}</td>
                                    <td>{{$performance['course_name']}}</td>
                                    <td>
                                        @if(count($performance['exam_marks']) > 0)
                                            @foreach ($performance['exam_marks'] as $examMark)
                                                <span class="badge text-bg-light border me-1 mb-1">
                                                    {{$examMark['exam_name']}}: {{$examMark['marks']}}
                                                </span>
                                            @endforeach
                                        @else
                                            <span class="text-muted">No exam marks</span>
                                        @endif
                                    </td>
                                    <td>{{$performance['calculated_marks']}}</td>
                                    <td>{{$performance['final_marks']}}</td>
                                    <td>{{$performance['grade']}}</td>
                                    <td>{{$performance['point']}}</td>
                                    <td>{{$performance['note']}}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">No marks or final grades found for this student in the selected class/section.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @include('layouts.footer')
        </div>
    </div>
</div>
@endsection
