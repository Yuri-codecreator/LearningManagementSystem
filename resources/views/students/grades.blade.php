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
                                    <th scope="col">Calculated Marks</th>
                                    <th scope="col">Final Grade (Marks)</th>
                                    <th scope="col">Letter Grade</th>
                                    <th scope="col">Grade Point</th>
                                    <th scope="col">Teacher Note</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($final_marks as $mark)
                                <tr>
                                    <td>{{optional($mark->semester)->semester_name ?? 'N/A'}}</td>
                                    <td>{{optional($mark->course)->course_name ?? 'N/A'}}</td>
                                    <td>{{$mark->calculated_marks}}</td>
                                    <td>{{$mark->final_marks}}</td>
                                    <td>{{$mark->getAttribute('grade')}}</td>
                                    <td>{{$mark->getAttribute('point')}}</td>
                                    <td>{{$mark->note ?? '-'}}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">No final grades found for this student in the selected class/section.</td>
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
