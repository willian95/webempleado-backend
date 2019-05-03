@extends('layouts.main')

@section('title')
    Login
@endsection

@section('content')
    
    <section id="main" class="padding-main">
        <div class="container fill">
            <div class="card fill no-border rounded-border shadow">
                <div class="card-body fill no-padding">
                    <div class="row fill">
                        <div class="col-lg-6 col-md-12">
                            <div class="flex-container fill">
                                <div>
                                    <img src="{{ asset('img/logo.png') }}" class="w-100">
                                    <h1 class="text-center bold margin-t-4-rem main-title">Web Empleado</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 blue-background rounder-border-right">
                                @if(session('message'))
                                    <div class="custom-alert">
                                        <div class="alert alert-danger fadeIn animated">
                                          {{session('message')}}
                                        </div>
                                    </div>
                                @endif
                            <div class="flex-container fill">
                                <div class="w-100 padding-center">
                                    <h2 class="text-center text-white bold secondary-title">Login</h2>
                                    <form class="margin-t-4-rem" method="post" action="{{ url('/login') }}" id="submit-form">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <input maxlength="8" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Cedula" name="cedula" v-model="cedula" v-on:keypress="isNumber(event)">
                                            <div class="alert alert-danger fadeIn animated" v-if="error.cedula.length > 0">@{{ error.cedula }}</div>
                                        </div>
                                        <div class="form-group">
                                            <input maxlength="20" type="password" class="form-control" id="exampleInputPassword1" placeholder="Clave" name="clave" v-model="clave">
                                            <div class="alert alert-danger fadeIn animated" v-if="error.clave.length > 0">@{{ error.clave }}</div>
                                        </div>
                                        <p class="text-center">
                                            <button type="button" @click="validate()" class="btn btn-orange bold">Ingresar</button>
                                        </p>
                                    </form> 

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('css')

    <style type="text/css">
        #main{
            width: 100%;
            height: 100%;
            position: absolute;
            /*background-image: linear-gradient(120deg, #e0c3fc 0%, #8ec5fc 100%);*/
            /*background: #2980B9;
            background: -webkit-linear-gradient(to right, #FFFFFF, #6DD5FA, #2980B9);
            background: linear-gradient(to right, #FFFFFF, #6DD5FA, #2980B9);*/
            /*background: #373B44;  
            background: -webkit-linear-gradient(to right, #4286f4, #373B44);  
            background: linear-gradient(to right, #4286f4, #373B44);*/
            /*background: #aa4b6b;
            background: -webkit-linear-gradient(to right, #3b8d99, #6b6b83, #aa4b6b);
            background: linear-gradient(to right, #3b8d99, #6b6b83, #aa4b6b);*/
            background: #7F7FD5;
            background: -webkit-linear-gradient(to right, #91EAE4, #86A8E7, #7F7FD5);
            background: linear-gradient(to right, #91EAE4, #86A8E7, #7F7FD5);


        }

        .fill { 
            min-height: 100%;
            height: 100%;
        }

        .padding-main{
            padding: 10rem;
        }

        .padding-center{
            padding: 5rem;
        }

        .rounded-border{
            border-radius: .5rem;
        }

        .rounder-border-right{
            border-bottom-right-radius: .5rem;
            border-top-right-radius: .5rem;
        }

        .no-border{
            border: none;
        }

        .blue-background{
            background: #60b3fe;
        }

        .no-padding{
            padding: 0rem;
        }

        .margin-t-4-rem{
            margin-top: 4rem;
        }

        .flex-container{
            padding: 0;
            margin: 0;
            display: -webkit-box;
            display: -moz-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-control{
            color: #000 !important;
        }

        .btn-orange{
            background-color: #f56e1f;
            color: #fff;
            border-radius: 50px;
        }

        .btn-orange:hover{
            color: #000;
            background-color: #EDDDD4;
            -webkit-box-shadow: 0 4px 5px 0 rgba(0,0,0,0.14), 0 1px 10px 0 rgba(0,0,0,0.12), 0 2px 4px -1px rgba(0,0,0,0.3);
            box-shadow: 0 4px 5px 0 rgba(0,0,0,0.14), 0 1px 10px 0 rgba(0,0,0,0.12), 0 2px 4px -1px rgba(0,0,0,0.3);
        }

        .bold{
            font-weight: bold;
        }

        .shadow{
            /*-webkit-box-shadow: 0 8px 17px 2px rgba(0,0,0,0.14), 0 3px 14px 2px rgba(0,0,0,0.12), 0 5px 5px -3px rgba(0,0,0,0.2);
            box-shadow: 0 8px 17px 2px rgba(0,0,0,0.14), 0 3px 14px 2px rgba(0,0,0,0.12), 0 5px 5px -3px rgba(0,0,0,0.2);*/
            -webkit-box-shadow: 0 24px 38px 3px rgba(0,0,0,0.14), 0 9px 46px 8px rgba(0,0,0,0.12), 0 11px 15px -7px rgba(0,0,0,0.2);
            box-shadow: 0 24px 38px 3px rgba(0,0,0,0.14), 0 9px 46px 8px rgba(0,0,0,0.12), 0 11px 15px -7px rgba(0,0,0,0.2);
        }

        .custom-alert{
            position: absolute;
            width: 100%;
            margin-left: -15px;
            text-align: center;
            padding-left: 2rem;
            padding-right: 2rem;
            padding-top: 2rem;
        }

        @media screen and (max-width: 1024px){

            .padding-main{
                padding: 5rem;
            }

            .padding-center{
                padding: 2rem;
            }

        }

        @media screen and (max-width: 991px){
            .margin-t-4-rem{
                margin-top: 0rem;
            }

            .blue-background{
                background-color: unset;
            }

            .secondary-title{
                color: #60b3fe !important;
            }

            .main-title{
                font-size: 2rem;
            }

            .row .col-lg-6:last-child{
                margin-top: -170px;
            }

        }



    </style>


@endsection

@section('scripts')
    <script>
   const app= new Vue({
        el:'#main',
        data:{
            clave: "",
            cedula: "",
            error:{
                cedula:"",
                clave:""
            }
        },
        methods:{
            
            isNumber:function(evt){

                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;

                console.log(charCode)

                if ((charCode > 31 && (charCode < 48 || charCode > 57))) {
                    evt.preventDefault();;
                } else {
                    return true;
                }

            },
            validate:function(){

                var isError = false

                if(!this.clave){
                    this.error.clave = "Clave no puede estar vacío"
                    isError = true
                }

                if(!this.cedula){
                    this.error.cedula = "Cédula no puede estar vacío"
                    isError = true
                }

                if(isError == false){
                    $("#submit-form").submit()
                }

            }

        },//methods
   });//const app= new Vue
</script>
@endsection
