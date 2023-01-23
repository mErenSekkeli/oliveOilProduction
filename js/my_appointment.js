function cancelApp(id){
    var process = "controller/my_appointment_controller.php";
    var str = "appointment_id=" + id + "&cancelAppointment=" + 1;
    $.ajax({
        type: "POST",
        url: process,
        data: str,  
        success: function(data) {
            var returned = JSON.parse(data);
            if(returned.status == "success"){
                swal('Başarılı', 'Randevunuz İptal Edildi!', 'success');
                setTimeout(function(){
                    $("#appointmentTable").load("my_appointments.php #appointmentTable");
                }, 1000);
            }else if(returned.status == "error"){
                swal('Hata!', 'Randevunuz İptal Edilemedi!', 'error');
            }
        }
    });
    }

    function deleteApp(id){
    event.preventDefault();
    var process = "controller/my_appointment_controller.php";
    var str = "appointment_id=" + id + "&deleteAppointment=" + 1;
    $.ajax({
        type: "POST",
        url: process,
        data: str,  
        success: function(data) {
            var returned = JSON.parse(data);
            if(returned.status == "success"){
                swal('Başarılı', 'Randevunuz Silindi!', 'success');
                setTimeout(function(){
                    $("#appointmentTable").load("my_appointments.php #appointmentTable");
                }, 1000);
            }else if(returned.status == "error"){
                swal('Hata!', 'Randevunuz Silinemedi!', 'error');
            }
        }
    });
    }