@extends('layouts.master')

@section('main-content')
<div class="container bootstrap snippet">
<div class="panel-body inf-content">
    <div class="row">
        <div class="col-md-4">
            <img alt="" style="width:600px;" title="" class="img-circle img-thumbnail isTooltip" src="/images/foods/" data-original-title="Usuario"> 
        </div>
        <div class="col-md-6 h4">
            <strong>Food Information</strong><br>
            <div class="table-responsive">
            <table class="table table-condensed table-responsive table-user-information">
                <colgroup>
                    <col class="col-md-2">
                    <col class="col-md-6">
                </colgroup>
                <tbody>
                    <tr>        
                        <td>
                            <strong>
                                <span class="glyphicon glyphicon-asterisk text-primary"></span>
                                Identificacion                                                
                            </strong>
                        </td>
                        <td class="text-primary">
                            {{$food->id}}     
                        </td>
                    </tr>
                    <tr>    
                        <td>
                            <strong>
                                <span class="glyphicon glyphicon-cutlery  text-primary"></span>    
                                Name                                         
                            </strong>
                        </td>
                        <td class="text-primary">
                            {{$food->name}}
                        </td>
                    </tr>

                    <tr>        
                        <td>
                            <strong>
                                <span class="glyphicon glyphicon-bookmark text-primary"></span> 
                                Category
                            </strong>
                        </td>
                        <td class="text-primary">
                            {{$category->name}}
                        </td>
                    </tr>
                    <tr>        
                        <td>
                            <strong>
                                <span class="glyphicon glyphicon-usd text-primary"></span> 
                                Price                                          
                            </strong>
                        </td>
                        <td class="text-primary">
                            {{ $food->price }}$
                        </td>
                    </tr>
                    <tr>        
                        <td>
                            <strong>
                                <span class="glyphicon glyphicon-tasks text-primary"></span> 
                                Description                                          
                            </strong>
                        </td>
                        <td class="text-primary">
                            {{$food->description}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>
                                <span class = "text-primary"></span>
                                Action
                            </strong>
                        </td>
                        <td>
                            <a href="/food/{{$food->id}}/edit"><span class="btn btn-success">Edit</span></a>
                             <a href="/food/{{$food->id}}"><span class="btn btn-danger">Delete</span></a>
                        </td>
                    </tr>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
</div>      
@endsection