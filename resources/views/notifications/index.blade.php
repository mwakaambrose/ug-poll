@extends('layouts.app')
@section('content')


 <form   method="GET" action="/notification">  
 	@csrf
        <legend>Send to all Extension Workers</legend>
        <label for="title1">Title</label><p />
        <input type="text" id="title1" name="title"  placeholder="Enter title"><p />

        <label for="message1">Message</label><p />
       <textarea  name="message" id="message1"  placeholder="Notification message!"></textarea><p />
        <input type="hidden" name="push_type" value="topic"/><p />
        <button type="submit" >Send </button>     
 </form>
  <style type="text/css">
            body{
            }
            div.container{
                width: 1000px;
                margin: 0 auto;
                position: relative;
            }
            legend{
                font-size: 30px;
                color: #555;
            }
            .btn_send{
                background: #00bcd4;
            }
            label{
                margin:10px 0px !important;
            }
            textarea{
                resize: none !important;
            }
            .fl_window{
                width: 400px;
                position: absolute;
                right: 0;
                top:100px;
            }
            pre, code {
                padding:10px 0px;
                box-sizing:border-box;
                -moz-box-sizing:border-box;
                webkit-box-sizing:border-box;
                display:block; 
                white-space: pre-wrap;  
                white-space: -moz-pre-wrap; 
                white-space: -pre-wrap; 
                white-space: -o-pre-wrap; 
                word-wrap: break-word; 
                width:100%; overflow-x:auto;
            }

        </style>
@endsection