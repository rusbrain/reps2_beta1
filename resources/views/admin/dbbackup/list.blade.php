@extends('admin.layouts.admin')
@inject('admin_helper', 'App\Services\AdminViewHelper')

@section('css')
@endsection

@section('page_header')
    базой данных
    <small>Управление базой данных</small>
@endsection

@section('breadcrumb')
    <li><a href="{{route('admin.home')}}"><i class="fa fa-dashboard"></i>базой данных</a></li>
    <li class="active">базой данных</li>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">               
        <!--//Account list-->
        <div class="box account_list">
          
            <!-- /.box-header -->
            <div class="box-body">
                <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                <thead>
                                    <tr role="row">
                                        <th class="text-center" style="width: 15%;">Имя БД</th>
                                        <th class="text-center" style="width: 15%;">Pазмер файла</th>
                                        <th class="text-center" style="width: 15%;">Дата</th>
                                        <th class="text-center" width="15%" class="text-center">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>                                            
                                    @foreach ($files as $tr)                                               
                                        <tr class="gradeA odd">
                                            <td class="text-center">{{$tr['dbname']}}</td>
                                            <td class="text-center">{{$tr['size'] }}</td>
                                            <td class="text-center">{{$tr['name'] }}</td>
                                            <td class="text-center">
                                                <div class="btn-group">                                                    
                                                    <a type="button" class="btn btn-default text-aqua"  title="Скачать" href="{{route('admin.dbbackup.download',['file' => $tr['basename']])}}"><i class="fa fa-download"></i></a>
                                                    <a type="button" class="btn btn-default text-red"  title="удалять" href="{{route('admin.dbbackup.filedelete',['file' => $tr['basename']])}}"><i class="fa fa-trash"></i></a>
                                                </div>                                                
                                            </td>   
                                        </tr>                                               
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="dataTables_info" id="dataTables-example_info" role="alert" aria-live="polite" aria-relevant="all">Tatal counts</div>

                                </div>
                                 <div class="col-sm-9 ">
                                    <div  id="dataTables-example_paginate" style="float:right">
                                        

                                    </div>
                                </div> 
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <!-- /.box -->
        </div>
    </div>
    <!-- /.col -->
</div>
@endsection