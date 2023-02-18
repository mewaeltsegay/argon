function send(data,table){
    $.post("./api/get.php",data,"json").done((ret)=>{
        var response = JSON.parse(ret)

        if(response.success === "true"){
            table.rows.add(response.data).draw(false)
        }
    })
}

function get(data,callback){
    $.post("./api/get.php",data,"json").done((ret)=>{
        var response = JSON.parse(ret)

        if(response.success === "true"){
            callback(response.data)
        }
    })
}

function set(data,callback){
    $.post("./api/set.php",data,"json").done((ret)=>{
        var response = JSON.parse(ret)

        callback(response)
    })
}

function put(data,callBack){
    $.post("./api/put.php",data,"json").done((ret)=>{
        var response = JSON.parse(ret)
        callBack(response.success)
    })
}

function del(data,callBack){
    $.post("./api/delete.php",data,"json").done((ret)=>{
        var response = JSON.parse(ret)
        callBack(response)
    })
}


function showNotification(from, align,type,message) {
    color = type;

    $.notify({
        icon: "nc-icon nc-bell-55",
        message: message

    }, {
        type: color,
        timer: 1000,
        placement: {
            from: from,
            align: align
        }
    })
}

function jsonToCsv(items) {
    const header = Object.keys(items[0]);

    const headerString = header.join(',');

    // handle null or undefined values here
    const replacer = (key, value) => value ?? '';

    const rowItems = items.map((row) =>
        header
            .map((fieldName) => JSON.stringify(row[fieldName], replacer))
            .join(',')
    );

    // join header and body, and break into separate lines
    const csv = [headerString, ...rowItems].join('\r\n');

    return csv;
}

function downloadBlob(content, filename, contentType) {
    // Create a blob
    var blob = new Blob([content], { type: contentType });
    var url = URL.createObjectURL(blob);

    // Create a link to download it
    var pom = document.createElement('a');
    pom.href = url;
    pom.setAttribute('download', filename);
    pom.click();
}


