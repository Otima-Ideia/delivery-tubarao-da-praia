@extends('layouts.admin')

@section('content')
<style>
body {font-family: Arial, Helvetica, sans-serif;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 9999; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;c
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
  z-index:9999;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover, 
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer; 
}
</style>

@if($caixaAberto)
<h1>Table aberto</h1> 
<input type="button" id="cashierOpen" class="btn btn-info" value="Novo pedido">
<input type="button" id="cashierOpen" class="btn btn-info" value="Novo Pedido no balcao">


@else 

<h1>CAIXA FECHADO</h1>
<!--{!! Form::model(null, ['route' => ['admin.cashier.storeC'], 'files' => false]) !!}-->
<!-- {{ Form::submit('Abrir caixa', ['class' => 'btn btn-success']) }}-->
<!-- {!! Form::close() !!}-->
 <input type="button" id="cashierOpen" class="btn btn-info" value="Abrir Caixa">
 
 
@endif












</script>

@endsection