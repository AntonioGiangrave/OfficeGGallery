@extends('layouts.dashboard')
@section('page_heading','Ferie e Permessi')


@section('section')


    @if(count($errors->all()) > 0)
        <div class="alert alert-danger" role="alert">  <p><b>OOOPS!</b></p>
            <ul>
                @foreach($errors->all() as $e)
                    <li>{{$e}}</li>
                @endforeach
            </ul>
        </div>
    @endif





    {{ Form::open(['route' => 'calendario.store']) }}

    <div class="form-group">
        {{ Form::hidden('dipendenti_id', Auth::user()->id, ['class' => 'form-control', 'id' => 'dipendenti_id'  ]) }}
        {{ Form::hidden('type', 0, ['class' => 'form-control' , 'id' => 'type']) }}

    </div>


    <div class="col-xs-6">

        {{ Form::label('Scegli Ferie, permesso o recupero ') }}
        <div class="list-group">
            <a href="#"
               commessa_id="10001"
               commessa_text="Ferie"
               type="0"
               class="list-group-item  ferieGroup">
                Ferie
            </a>

            <a href="#"
               commessa_id="10000"
               commessa_text="Permesso"
               type="0"
               class="list-group-item  ferieGroup">
                Permesso
            </a>


            <div class="list-group">
                @foreach($crediti as $single)
                    <a href="#"
                       commessa_id="{{ $single->commessa_id; }}"
                       commessa_text="Recupero per {{ $single->oggetto; }}"
                       type="3"
                       class="list-group-item  list-group-item-warning  ferieGroup">
                        Recupero per {{ $single->oggetto; }}
                        <span class="badge">{{ $single->credito; }}</span>
                    </a>
                @endforeach
            </div>





        </div>
    </div>


    <style>
        .autoWidth {
            width: auto;
            margin:10px;

        }
    </style>


    <div class="col-xs-6">


        {{ Form::label('commessa_id_text', 'Motivo:') }}
        {{ Form::text('commessa_id_text', null, ['class' => 'form-control', 'disabled']) }}
        {{ Form::hidden('commessa_id', null, ['id'=>'commessa_id' ,  'class' => 'form-control'  ]) }}

        <br>
        <div class="form-group">
            {{ Form::label('giorno', 'Giorno:') }}
            {{ Form::text('giorno', null, ['class' => 'form-control']) }}
        </div>

        <div class="form-inline">
            <div class="form-group">
                {{ Form::label('dalle_ore', 'Dalle ore:') }}
                {{ Form::select('dalle_ore', array(9 => 9,10 => 10,11 => 11,12 => 12,13 => 13,14 => 14 ,15 => 15 ,16 => 16,17 =>17,18 => 18 ) , null,['class' => 'form-control autoWidth' ]) }}
                {{ Form::select('dalle_minuti', array('0' => '00' , '30'=>' e mezza'),null,   ['class' => 'form-control autoWidth ']) }}

            </div>
        </div>

        <div class="form-group">
            {{ Form::label('n_ore', 'Numero ore:') }}
            {{ Form::text('n_ore', null, ['class' => 'form-control', 'placeholder' => 'per le mezzore inserisci  ,5']) }}
        </div>

        <div class="pull-right">
            {{ Form::submit('Invia', ['class' => 'btn btn-success']) }}
            {{ Form::close() }}
        </div>

    </div>
@stop

@section('script')
    <script type="text/javascript">

        $( document ).ready(function()
        {

            $(".ferieGroup").click(function() {
                $('#commessa_id_text').val($(this).attr("commessa_text"));
                $('#commessa_id').val($(this).attr("commessa_id"));
                $('#type').val($(this).attr("type"));

            });


            $( "#giorno" ).datepicker({
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true
            });





        });



    </script>

@endsection
