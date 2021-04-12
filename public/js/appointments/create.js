let $doctor, $date, $specialty;
let iRadio;
const noHoursAlert = `<div class="alert alert-danger" role="alert">
  <strong>Lo sentimos!</strong> No se encontraron horas disponibles de este médico, para el dia seleccionado.
</div>`

$(function() {
    $specialty = $('#specialty');
    $doctor = $('#doctor');
    $date = $('#date');
    $hours = $('#hours');

    $specialty.change(() => {
        const specialtyId = $specialty.val();
        const url = `/specialties/${specialtyId}/doctors`;
        $.getJSON(url, onDoctorsLoaded);
    });
    $doctor.change(loadHours);
    $date.change(loadHours);
});
function onDoctorsLoaded(doctors) {
    //console.log(data);
    let htmlOptions = '';
    doctors.forEach(doctor => {
        htmlOptions += `<option value="${doctor.id}">${doctor.name}</option>`;
    });
    $doctor.html(htmlOptions);
    loadHours();
}
function loadHours() {
    const selectedDate = $date.val();
    const doctorId = $doctor.val();
    const url = `/schedule/hours?date=${selectedDate}&doctor_id=${doctorId}`;
    $.getJSON(url, displayHours);
}
function displayHours(data) {
    //console.log(data)
    if (!data.morning && !data.afternoon) {
        $hours.html(noHoursAlert);
        return;
    }
    let htmlHours = '';
    iRadio = 0;
    if (data.morning) {
        const morning_intervals = data.morning;
        morning_intervals.forEach(interval => {
           //console.log(`${interval.start} - ${interval.end}`);
            htmlHours += getRadioIntervalHtml(interval);
        });
    }
    if (data.afternoon) {
        const afternoon_intervals = data.afternoon;
        afternoon_intervals.forEach(interval => {
            console.log(`${interval.start} - ${interval.end}`);
            htmlHours += getRadioIntervalHtml(interval);
        });
    }
    $hours.html(htmlHours);
}

function getRadioIntervalHtml(interval) {
    const text = `${interval.start} - ${interval.end}`;

    return `<div class="custom-control custom-radio mb-3">
  <input name="scheduled_time" value="${interval.start}" class="custom-control-input" id="interval${iRadio}" type="radio" required>
  <label class="custom-control-label" for="interval${iRadio++}">${text}</label>
</div>`
}
