<!--
    Autor(i):
    Aleksa Savic 19/0039
-->

@extends("template")

@section('content')

    <div class="row">
        <h1>Globalna rang lista</h1>
        <div class="col-md-12">
            <table class="table">
                <table class="table table-bordered table-striped">
                    @foreach ($rankList as $listRow)
                        <tr>
                            <td>{{++$i}}.</td>
                            <td rowspan="3" class="col-sm-5 align-middle">{{$listRow->userModel->username}}</td>
                            <td rowspan="3" class="col-sm-3 align-middle text-center">
                                Vreme: {{$listRow->time}}, WPM: {{$listRow->wpm}}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </table>
        </div>
    </div>
@endsection
