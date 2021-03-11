$("#btnAddUser").click(function(event) {
    var form = $("#formAddUser");
    event.preventDefault();
    event.stopPropagation();

    if (form[0].checkValidity() !== false) {
        if (isNaN($("#personnel_num").val())) return alert("Персональный номер должен быть числом");
        var reFIO = new RegExp("^[А-Яа-я]+$", "ui");
        if (!reFIO.test($("#surname").val())) return alert("В Фамилии разрешены только русские буквы");
        if (!reFIO.test($("#name").val())) return alert("В Имени разрешены только русские буквы");
        if (!reFIO.test($("#patronymic").val())) return alert("В Фамилии разрешены только русские буквы");
        var rePost = new RegExp("^[А-Яа-я0-9. -]+$", "ui");
        if (!rePost.test($("#post").val())) return alert("В должности разрешены только цифры, русские буквы, символы \".\", \"-\" и пробел");
        $.ajax({
            type: 'post',
            url: 'index.php',
            data: form.serialize(),
            success: function (data) {
                var data = $.parseJSON(data);
                alert(data["response"]);
                if (data["result"]) location.href = 'index.php';
            }
        });
    }
    form.addClass('was-validated');
});

$("#btnAddDev").click(function(event) {
    var form = $("#formAddDev");
    event.preventDefault();
    event.stopPropagation();

    if (form[0].checkValidity() !== false) {
        if (isNaN($("#inventory_num").val())) return alert("Инвентарный номер должен быть числом");
        var reNameDev = new RegExp("^[А-Яа-яA-Za-z0-9. -]+$", "ui");
        if (!reNameDev.test($("#device_name").val())) return alert("В названии устройства разрешены только цифры, русские-латинские буквы, символы \".\", \"-\" и пробел");
        var reIp = new RegExp("(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)", "ui");
        if (!reIp.test($("#ip_adress").val())) return alert("ip-адресс должен иметь вид 255.255.255.255");
        var reCartrige = new RegExp("^[А-Яа-яA-Za-z0-9 -]+$", "ui");
        if (!reCartrige.test($("#cartrige").val()) && $("#cartrige").val().length) return alert("В названии картриджа разрешены только цифры, латинские буквы, символы \"-\" и пробел");

        $.ajax({
            type: 'post',
            url: 'index.php',
            data: form.serialize(),
            success: function (data) {
                var data = $.parseJSON(data);
                alert(data["response"]);
                if (data["result"]) location.href = 'index.php';
            }
        });
    }
    form.addClass('was-validated');
});

$("#btnDelDev").click(function(event) {
    event.preventDefault();
    event.stopPropagation();

    if(!$("#inventory_num").val()) return alert("Не указан инвентарый номер");
    $("#action").attr("value", "delete_device");
    var form = $("#formAddDev");

    $.ajax({
        type: 'post',
        url: 'index.php',
        data: form.serialize(),
        success: function (data) {
            var data = $.parseJSON(data);
            alert(data["response"]);
            if (data["result"]) location.href = 'index.php';
        }
    });
});

$("#btnLogin").click(function(event) {
    event.preventDefault();
    event.stopPropagation();

    var form = $("#formLoginUser");

    if(!$("#login").val()) return alert("Не указан логин");
    if(!$("#pass").val()) return alert("Не указан пароль");

    $.ajax({
        type: 'post',
        url: 'index.php',
        data: form.serialize(),
        success: function (data) {
            var data = $.parseJSON(data);
            alert(data["response"]);
            if (data["result"]) location.href = 'index.php';
        }
    });
});

$("#btnLogin").click(function(event) {
    event.preventDefault();
    event.stopPropagation();

    var form = $("#formLoginUser");

    if(!$("#login").val()) return alert("Не указан логин");
    if(!$("#pass").val()) return alert("Не указан пароль");

    $.ajax({
        type: 'post',
        url: 'index.php',
        data: form.serialize(),
        success: function (data) {
            var data = $.parseJSON(data);
            alert(data["response"]);
            if (data["result"]) location.href = 'index.php';
        }
    });
});