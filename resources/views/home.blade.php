@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <section class="offset-1 col-md-10 mainSection">
                <h1>{{ env('APP_NAME', "Nissan Oculus experience KPI") }} @if($storeObject) : {{$storeObject->name}} @endif</h1>

                <div class="row">
                    <div class="col-sm-12">
                        <h2>Reporte de eventos detallado</h2>
                        <p>Elige una tienda y rango de fechas para filtrar los resultados.</p>
                    </div>
                </div>
                <form action="{{ url('home') }}" method="GET" id="filterForm" style="width: 100%;">
                    <section class="filtersRow row">
                        <div class="each-filter col">
                            <div class="form-group">
                                <select class="form-control" id="storeSelect" name="store">
                                    <option value="">Elige una tienda</option>
                                    @foreach($stores as $myStore)
                                        <option value="{{$myStore->identifier}}" {{ set_active('/', $myStore->identifier, 'selected') }}>{{ $myStore->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="each-filter col">
                            <input type='text'  width="100%" value="{{ $from }}" name="from" id="datepicker_start" placeholder="AAAA/MM/DD" />
                        </div>
                        <div class="each-filter col">
                            <input type='text'  width="100%" value="{{ $to }}" name="to" id="datepicker_end" placeholder="AAAA/MM/DD" />
                        </div>
                        <div class="each-filter col">
                            <div class="form-group">
                                <div class='input-group'>
                                    <button class="btn btn-primary btn-block" type="submit">Filtrar</button>
                                    </br>
                                    </br>
                                    <a id="generateReport" class="btn btn-success btn-block" type="button">Descargar .csv</a>
                                </div>
                            </div>
                        </div>
                    </section>
                    <div class="row">
                        <div class="col-md-12" >

                            <div class="table-responsive">
                                <table class="userLogTable table table-striped table-fixed">

                                    <thead>
                                        <tr>
                                            <th class="col-2">Fecha</th>
                                            <th class="col-2">Equipo</th>
                                            <th class="col-2">Nivel</th>
                                            <th class="col-2">Interacciones</th>
                                            <th class="col-2">Duración</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                    @if(!empty($full_log))
                                        @foreach($full_log as $log_entry)
                                            <tr>
                                                <td class="col-2">{{ $log_entry->timestamp }}</td>
                                                <td class="col-2">{{ $log_entry->device_id }}</td>
                                                <td class="col-2"><strong>{{ $log_entry->event['name'] }}</strong></td>
                                                <td class="col-2">{{ $log_entry->event['actions']->interaction }}</td>
                                                <td class="col-2">{{ round($log_entry->event['actions']->timeSpent,1) }} seg</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="3">No hay registros</td>
                                        </tr>
                                    @endif

                                    </tbody>

                                </table>
                            </div>

                        </div>
                    </div>
                </form>

                <section class="row">

                    <div class="col">

                        <h2><i class="material-icons">info</i> Notificaciones</h2>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-striped table-sm table-fixed">

                                <tbody>
                                    @if(!empty($notifications))
                                        @foreach($notifications as $log_entry)
                                            <tr>
                                                <td class="col-12">{{$log_entry}}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="col-12">No hay notificaciones</td>
                                        </tr>
                                    @endif
                                </tbody>

                            </table>
                        </div>

                    </div>

                    <div class="col">
                        <h2>KPI</h2>

                        <section class="card dataCard">

                            <div class="card-body">
                                <div class="card-title">Dispositivos</div>
                                <div class="card-content">
                                    <doughnut-chart
                                            :labels="['Activos','Registrados']"
                                            :values="[{{$active_device_count}},{{ $device_count-$active_device_count }}]"
                                    >
                                    </doughnut-chart>
                                    <div class="center-icon under">
                                        <i class="material-icons">
                                            phone_android
                                        </i>
                                    </div>
                                    <h3>{{ $active_device_count }} / {{ $device_count }}</h3>
                                </div>
                                <div class="card-subtitle">( activos / registrados )</div>
                            </div>
                        </section>

                        <section class="card dataCard">

                            <div class="card-body">
                                <div class="card-title">Accesos únicos promedio</div>
                                <div class="center-icon">
                                    <br>
                                    <br>
                                    <i class="material-icons">
                                        track_changes
                                    </i>
                                </div>
                                <div class="card-content">
                                    <h3>{{ $event_count }}</h3>
                                </div>
                            </div>
                        </section>

                        <section class="card dataCard">

                            <div class="card-body">
                                <div class="card-title">Sesión promedio</div>
                                <div class="center-icon">
                                    <br>
                                    <br>
                                    <i class="material-icons">
                                        alarm
                                    </i>
                                </div>
                                <div class="card-content">
                                    <h3>{{ round($session_length, 1) }} seg</h3>
                                </div>
                            </div>
                        </section>

                        <section class="card dataCard">
                            <div class="card-body" >
                                <div class="card-title">Gráficas</div>
                                <div class="card-content">
                                    <button class="btn btn-primary btn-block">Interacciones/Tienda</button>
                                    <button class="btn btn-primary btn-block">Nivel/Tiempo</button>
                                </div>
                            </div>

                        </section>

                    </div>


                </section>

            </section>
        </div>
    </div>

@endsection