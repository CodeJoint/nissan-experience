@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <section class="offset-1 col-md-10 mainSection">
                <h1>{{ env('APP_NAME', "Nissan Oculus experience KPI") }} @if($storeObject) : {{$storeObject->name}} @endif</h1>

                <div class="row">
                    <div class="col-sm-12">
                        <h2>Reporte de eventos detallado</h2>
                        <p>Elige una tienda y rango de fechas para filtrar los resultados y poder generar los reportes y gráficas.</p>
                    </div>
                </div>
                <form action="{{ url('home') }}" method="GET" id="filterForm" style="width: 100%;">
                    <section class="filtersRow row">
                        <div class="each-filter col">
                            <div class="form-group">
                                <select class="form-control" id="storeSelect" name="store">
                                    <option value="">Todas las tiendas</option>
                                    @foreach($stores as $myStore)
                                        <option value="{{$myStore->identifier}}" {{ set_active('/', $myStore->identifier, 'selected') }}>{{ $myStore->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="each-filter col">
                            <input type='text'  width="100%" value="{{ $from }}" name="from" id="datepicker_start" placeholder="AAAA-MM-DD" />
                        </div>
                        <div class="each-filter col">
                            <input type='text'  width="100%" value="{{ $to }}" name="to" id="datepicker_end" placeholder="AAAA-MM-DD" />
                        </div>
                        <div class="each-filter col">
                            <div class="form-group">
                                <div class='input-group'>
                                    <button class="btn btn-primary btn-block filterButtons" type="submit">Filtrar</button>
                                    <a id="generateReport" class="btn btn-success btn-block filterButtons" type="button">Descargar .csv</a>
                                </div>
                            </div>
                        </div>
                    </section>
                    <div class="row">
                        <div class="col-md-12" >

                            <div class="table-responsive tableResponsiveFix">
                                <table class="userLogTable table table-striped table-condensed">

                                    <thead>
                                        <tr class="clearfix">
                                            <th class="col-2">Fecha</th>
                                            <th class="col-2">Equipo</th>
                                            <th class="col-2">Niveles</th>
                                            <th class="col-2">Niveles Visitados</th>
                                            <th class="col-2">Interacciones</th>
                                            <th class="col-2">Duración</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    @php(\Carbon\Carbon::setLocale('es'))
                                    @if(!empty($full_log))
                                        @foreach($full_log as $log_entry)
                                            <tr>
                                                <td class="col-2">{{ \Carbon\Carbon::createFromFormat( "Y-m-d H:i:s", $log_entry->timestamp )->diffForHumans() }}</td>
                                                <td class="col-2">{{ $log_entry->device_id }}</td>
                                                <td class="col-2">{{ $log_entry->level_count }}</td>
                                                <td class="col-2"><strong>{{ $log_entry->levels_concat }}</strong></td>
                                                <td class="col-2">{{ $log_entry->event['actions']->interaction }}</td>
                                                <td class="col-2">{{ round($log_entry->event['actions']->timeSpent, 1) }} seg</td>
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
                        <h2>KPI y Gráficas</h2>

                        <section class="card dataCard">

                            <div class="card-body">
                                <div class="card-title">Actividad  @if($storeObject) {{$storeObject->name}} @endif</div>
                                <div class="card-content">
                                    <doughnut-chart
                                        :labels="['Activos','Registrados']"
                                        :values="[{{$active_device_count}},{{ $device_count-$active_device_count }}]"
                                        chart-id="deviceChart"
                                        >
                                    </doughnut-chart>
                                    <div class="center-icon under">
                                        <i class="material-icons">
                                            phone_android
                                        </i>
                                    </div>
                                    <h3>{{ $active_device_count }} / {{ $device_count }}</h3>
                                </div>
                                <div class="card-subtitle">( dispositivos activos / registrados )</div>
                            </div>
                        </section>

                        <section class="card dataCard">

                            <div class="card-body">
                                <div class="card-title">Usuarios únicos promedio</div>
                                <div class="center-icon">
                                    <br>
                                    <br>
                                    <i class="material-icons">
                                        accessibility_new
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
                                    <h3>{{ round($session_length, 2) }} seg</h3>
                                </div>
                            </div>
                        </section>

                        <section class="card dataCard">
                            <div class="card-body" >
                                <div class="card-title"><i class="material-icons">multiline_chart</i> Gráficas generales</div>
                                <br>
                                <div class="card-content">
                                    <button id="inter_chart" class="btn btn-primary btn-block filterButtons fillWidth">Interacciones por tienda</button>
                                    <button id="level_chart" class="btn btn-primary btn-block filterButtons fillWidth">Tiempo en cada nivel</button>
                                </div>
                            </div>

                        </section>

                    </div>

                    <div id="dialog" title="Uso por tienda [{{ $from ." a " . $to }}]" width="800" style="display: none;">
                        <div data-role="body">

                            <line-chart
                                :values="{{ json_encode($chart_final['interaction']['values']) }}"
                                :labels="{{ json_encode($chart_final['interaction']['labels']) }}"
                                chart-id="interactionChart"
                                data-label="Uso por tienda"
                                >
                            </line-chart>
                        </div>
                        <div data-role="footer">
                            <button class="gj-button-md" onclick="dialog.close()">OK</button>
                        </div>
                    </div>

                    <div id="dialog2" title="Tiempo pasado por nivel [{{ $from ." a " . $to }}]" width="800" style="display: none;">
                        <div data-role="body">

                            <line-chart
                                :values="{{ json_encode($chart_final['level_time']['values']) }}"
                                :labels="{{ json_encode($chart_final['level_time']['labels']) }}"
                                chart-id="timeSpentChart"
                                data-label="Tiempo pasado por nivel"
                                >
                            </line-chart>
                        </div>
                        <div data-role="footer">
                            <button class="gj-button-md" onclick="dialog2.close()">OK</button>
                        </div>
                    </div>

                </section>

            </section>
        </div>
    </div>

@endsection