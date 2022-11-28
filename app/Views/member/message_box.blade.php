@extends('master.layout')

@section('content')

    <!-- Main content -->
    <section class="content">
        <!-- MAILBOX BEGIN -->
        <div class="mailbox row">
            <div class="col-xs-12">
                <div class="box box-solid">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-3 col-sm-4">
                                <div style="margin-top: 15px;">
                                <ul class="nav nav-pills nav-stacked">
                                    <li class="header">Folders</li>
                                    <li class="active"><a href="#"><i class="fa fa-inbox"></i> Unread  ({{unread_count()}})</a></li>
                                    <li><a href="#"><i class="fa fa-pencil-square-o"></i>All ({{ all_count() }})</a></li>
                                </ul>
                                </div>
                            </div><!-- /.col (LEFT) -->
                            <div class="col-md-9 col-sm-8">
                                <div class="row pad">
                                    <div class="col-sm-6">
                                        <label style="margin-right: 10px;">
                                            <input type="checkbox" id="check-all"/>
                                        </label>
                                        <!-- Action button -->
                                        <div class="btn-group">
                                            <a href='#' class="btn btn-default btn-sm btn-flat dropdown-toggle">
                                               <i class="fa fa-trash"></i>&nbsp;&nbsp; Delete 
                                            </a>
                                           <!--  <ul class="dropdown-menu" role="menu">
                                                <li><a href="#">Mark as read</a></li>
                                                <li><a href="#">Mark as unread</a></li>
                                                <li class="divider"></li>
                                                <li><a href="#">Move to junk</a></li>
                                                <li class="divider"></li>
                                                <li><a href="#">Delete</a></li>
                                            </ul> -->
                                        </div>

                                    </div>
                                    <div class="col-sm-6 search-form">
                                     <!--    <form action="#" class="text-right">
                                            <div class="input-group">                                                            
                                                <input type="text" class="form-control input-sm" placeholder="Search">
                                                <div class="input-group-btn">
                                                    <button type="submit" name="q" class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
                                                </div>
                                            </div>                                                     
                                        </form> -->
                                    </div>
                                </div><!-- /.row -->

                                <div class="table-responsive">
                                    <!-- THE MESSAGES -->
                                    <table class="table table-mailbox">
                                        {{ $message }}
                                        <!-- <tr class="unread">
                                            <td class="small-col"><input type="checkbox" /></td>
                                            
                                            <td class="name"><a href="#">John Doe</a></td>
                                            <td class="subject"><a href="#">Urgent! Please read</a></td>
                                            <td class="time">12:30 PM</td>
                                        </tr>
                                        <tr>
                                            <td class="small-col"><input type="checkbox" /></td>
                                            
                                            <td class="name"><a href="#">John Doe</a></td>
                                            <td class="subject"><a href="#">Urgent! Please read</a></td>
                                            <td class="time">12:30 PM</td>
                                        </tr>
                                        <tr>
                                            <td class="small-col"><input type="checkbox" /></td>
                                            
                                            <td class="name"><a href="#">John Doe</a></td>
                                            <td class="subject"><a href="#">Urgent! Please read</a></td>
                                            <td class="time">12:30 PM</td>
                                        </tr>
                                        <tr class="unread">
                                            <td class="small-col"><input type="checkbox" /></td>
                                            
                                            <td class="name"><a href="#">John Doe</a></td>
                                            <td class="subject"><a href="#">Urgent! Please read</a></td>
                                            <td class="time">12:30 PM</td>
                                        </tr>
                                        <tr>
                                            <td class="small-col"><input type="checkbox" /></td>
                                            
                                            <td class="name"><a href="#">John Doe</a></td>
                                            <td class="subject"><a href="#">Urgent! Please read</a></td>
                                            <td class="time">12:30 PM</td>
                                        </tr>
                                        <tr>
                                            <td class="small-col"><input type="checkbox" /></td>
                                            
                                            <td class="name"><a href="#">John Doe</a></td>
                                            <td class="subject"><a href="#">Urgent! Please read</a></td>
                                            <td class="time">12:30 PM</td>
                                        </tr>
                                        <tr>
                                            <td class="small-col"><input type="checkbox" /></td>
                                            
                                            <td class="name"><a href="#">John Doe</a></td>
                                            <td class="subject"><a href="#">Urgent! Please read</a></td>
                                            <td class="time">12:30 PM</td> -->
                                        </tr>
                                    </table>
                                </div><!-- /.table-responsive -->
                            </div><!-- /.col (RIGHT) -->
                        </div><!-- /.row -->
                    </div><!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <div class="pull-right">
                            <small>Showing 1-12/1,240</small>
                            <button class="btn btn-xs btn-primary"><i class="fa fa-caret-left"></i></button>
                            <button class="btn btn-xs btn-primary"><i class="fa fa-caret-right"></i></button>
                        </div>
                    </div><!-- box-footer -->
                </div><!-- /.box -->
            </div><!-- /.col (MAIN) -->
        </div>
        <!-- MAILBOX END -->

    </section><!-- /.content -->

@stop

@section('script')
@stop