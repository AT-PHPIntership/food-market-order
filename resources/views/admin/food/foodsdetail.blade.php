@extends('layouts.master')
@section('main-content')
<div class="container bootstrap snippet">
<div class="panel-body inf-content">
    <div class="row">
        <div class="col-md-4">
            <img alt="" style="width:600px;" title="" class="img-circle img-thumbnail isTooltip" src="http://khachsandanang.info/wp-content/uploads/2016/10/mi-quang.jpg" data-original-title="Usuario"> 
            <ul title="Ratings" class="list-inline ratings text-center">
                <li><span class="glyphicon glyphicon-star"></span></a></li>
                <li><span class="glyphicon glyphicon-star"></span></a></li>
                <li><span class="glyphicon glyphicon-star"></span></a></li>
                <li><span class="glyphicon glyphicon-star"></span></a></li>
                <li><span class="glyphicon glyphicon-star"></span></a></li>
            </ul>
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
                            123456789     
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
                            Noodles    
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
                            #
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
                            $1
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
                            Bootstrap is a free and open-source front-end web framework for designing websites and web applications. It contains HTML- and CSS-based design templates for typography, forms, buttons, navigation and other interface components, as well as optional JavaScript extensions.
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
                            <button class="btn btn-primary">
                              Edit
                            </button>
                            <button class="btn btn-danger">
                              Delete
                            </button>
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