@extends('layouts.auth_master')
@isset($all)
    <?php $title='إدارة المستخدمون';?>
@else
    <?php $title='المستخدمون غير النشيطون';?>
@endisset
@section('title', $title)
@section('content')
    <h3 class="text-center">
        أهلاً وسهلاً بك يا <span class="color-master">{{Auth()->User()->name}}</span>
    </h3>
    @if($users->count()>0)
        <div class="row mt-5">
            <div class="table-responsive text-right">
                <table class="table table-striped" id="users">
                    <thead>
                    <tr><th>#</th>
                        <th>اسم المستخدم</th>
                        <th>البريد الالكتروني</th>
                        <th>تم تأكيد البريد؟</th>
                        <th>تاريخ الانضمام</th>
                        <th>تفعيل / إيقاف</th>
                    </tr>
                </thead>
            <tbody>
        @foreach ($users as $index => $user)
            <tr>
                <th>{{++$index}}</th>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>
                    <span class="badge badge-{{$user->email_verified_at==null ? 'danger' : 'success'}}" title="{{$user->email_verified_at}}">
                        {{$user->email_verified_at==null ? 'لا' : 'نعم'}}
                    </span>
                </td>
                <td>{{Carbon\Carbon::parse($user->created_at)->toDateString()}}</td>
                <td>
                    <input type="checkbox" id="user{{$user->id}}" class="form-check-input"
                        name="user{{$user->id}}" value="{{$user->id}}"
                        data-on="تفعيل" data-off="إيقاف"
                        data-toggle="toggle" data-change="true" {{$user->active ? 'checked' : ''}}
                        data-onstyle="outline-success" data-offstyle="outline-danger"
                        data-style="slow" data-size="sm" onchange="set_active({{$user->id}});" />
                </td>
            </tr>
        @endforeach
            </tbody>
            </table>
            </div>
        </div>
        <div class="background">
        </div>
    @else
        <div class="mt-5 alert alert-info text-center">عذراً لا يوجد مستخدمون جدد!!!</div>
    @endif
@endsection
@section('scripts')
        <script>
            $(document).ready( function () {
                $('#users').DataTable({
                "language": {
                    "url": "{{URL::asset('/js/arabic.json')}}"
                    }
                });
            });
        </script>
@endsection
