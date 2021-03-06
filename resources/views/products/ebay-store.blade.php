@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <div class="panel panel-default">

                    <div class="panel-heading">
                        <h4 class="panel-title">
                            Choose How Many {{ $product->name }} do you Want To Store ?
                        </h4>
                    </div>

                    <div class="panel-body">

                        <div class="col-lg-6">
                            {!! Form::open(array('url'=>['ebaystore'])) !!}

                            <div class="form-group">
                                {!! Form::label('quantity') !!}
                                {!! Form::text('quantity',null,['class'=>'form-control','required']) !!}
                            </div>

                            <input type="hidden" name="price" value="{{ $product->price }}">
                            <input type="hidden" name="productname" value="{{ $product->name }}">
                            <input type="hidden" name="description" value="{{ $product->description }}">

                            {!! Form::submit('Send To Ebay',['class'=>'btn btn-primary pull-right']) !!}

                            {!! Form::close() !!}
                            <br><br>

                            <p class="text-center" style="padding:30px;background-color: #2b542c;font-size: 40px;color:#f5f5f5;">
                                ${{ $product->price }}
                                <small style="font-size: 13px;">Per {{ $product->name }}</small>
                            </p>
                        </div>

                        <div class="col-lg-6">
                            <img src="{{ url('assets/images/'.$product->image) }}" alt="{{ $product->name }}" class="img-responsive">
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection