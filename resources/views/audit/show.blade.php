@extends('adminlte::page')

@section('title', 'Ver Auditoria')

@section('content')
<br>
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Auditoria</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('audits.index') }}"> {{ __('Atrás') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        <div class="form-group mb-2 mb20">
                            <strong>Tipo de Usuario:</strong>
                            {{ class_basename($audit->user_type) }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Nombre de Usuario:</strong>
                            {{ optional($audit->user)->name }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>ID de Usuario:</strong>
                            {{ $audit->user_id }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Evento:</strong>
                            {{ $audit->event }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Tabla:</strong>
                            {{ class_basename($audit->auditable_type) }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>ID Auditable:</strong>
                            {{ $audit->auditable_id }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Valores Antiguos:</strong>
                            {{ $audit->old_values }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Valores Nuevos:</strong>
                            {{ $audit->new_values }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Fecha:</strong>
                            {{ $audit->created_at->format('d/m/Y H:i:s') }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>URL:</strong>
                            {{ $audit->url }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Dirección IP:</strong>
                            {{ $audit->ip_address }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Agente de Usuario:</strong>
                            {{ $audit->user_agent }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Etiquetas:</strong>
                            {{ $audit->tags }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
