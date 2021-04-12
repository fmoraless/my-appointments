@extends('layouts.panel')

@section('content')
    <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="mb-0">Registrar nueva cita</h3>
                </div>
                <div class="col text-right">
                    <a href="{{ url('patients') }}" class="btn btn-sm btn-default">Cancelar</a>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <!-- patients form -->
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ url('/appointments') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="description">Descripción</label>
                        <input type="text" class="form-control" name="description" id="description" required
                               placeholder="Describe brevemente la consulta" value="{{ old('description') }}">
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="specialty">Especialidad</label>
                            <select name="specialty_id" id="specialty" class="form-control" required>
                                <option value="">Seleccione una especialidad</option>
                                @foreach($specialties as $specialty)
                                    <option value="{{ $specialty->id }}"
                                            @if(old('specialty_id') == $specialty->id) selected @endif
                                    >{{ $specialty->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="doctor">Médico</label>
                            <select name="doctor_id" id="doctor" class="form-control">
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}"
                                            @if(old('doctor_id') == $doctor->id) selected @endif
                                    >{{ $doctor->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="dni">Fecha</label>
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                            </div>
                            <input type="text" name="scheduled_date" class="form-control datepicker"
                                   id="date"
                                   placeholder="Seleccionar fecha" value="{{ old('scheduled_date', date('Y-m-d')) }}"
                                   data-date-format="yyyy-mm-dd"
                                   data-date-start-date="{{ date('Y-m-d') }}"
                                   data-date-end-date="+30d"
                            >
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="address">Hora de atención</label>
                        <div id="hours">
                            @if($intervals)
                                @foreach($intervals['morning'] as $key => $interval)
                                    <div class="custom-control custom-radio mb-3">
                                        <input name="scheduled_time" value="{{ $interval->start }}" class="custom-control-input" id="intervalMorning{{ $key }}" type="radio" required>
                                        <label class="custom-control-label" for="intervalMorning{{ $key }}">{{ $interval->start }} - {{ $interval->end }}</label>
                                    </div>
                                @endforeach
                                @foreach($intervals['afternoon'] as $key => $interval)
                                        <div class="custom-control custom-radio mb-3">
                                            <input name="scheduled_time" value="{{ $interval->start }}" class="custom-control-input" id="intervalAfternoon{{ $key }}" type="radio" required>
                                            <label class="custom-control-label" for="intervalAfternoon{{ $key }}">{{ $interval->start }} - {{ $interval->end }}</label>
                                        </div>
                                @endforeach
                            @else
                                <div class="alert alert-info" role="alert">
                                    <strong>Lo sentimos!</strong> No se encontraron horas disponibles de este médico, para el dia seleccionado.
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="type">Tipo de consulta</label>
                        <div class="custom-control custom-radio mb-3">
                            <input type="radio" id="type1" name="type" class="custom-control-input"
                            @if(old('type', 'Consulta') == 'Consulta') checked @endif value="Consulta">
                            <label class="custom-control-label" for="type1">Consulta</label>
                        </div>
                        <div class="custom-control custom-radio mb-3">
                            <input type="radio" id="type2" name="type" class="custom-control-input"
                            @if(old('type') == 'Examen') checked @endif value="Examen">
                            <label class="custom-control-label" for="type2">Examen</label>
                        </div>
                        <div class="custom-control custom-radio mb-3">
                            <input name="type" class="custom-control-input" id="type3" type="radio"
                            @if(old('type') == 'Operación') checked @endif value="Operación">
                            <label class="custom-control-label" for="type3">Operación</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('/js/appointments/create.js') }}">


    </script>
@endsection


