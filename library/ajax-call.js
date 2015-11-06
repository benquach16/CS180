/**
 * Created by Calvin on 11/6/2015.
 */
jQuery.extend({
    getValues: function(url, method, data, type) {
        var result = null;
        $.ajax({
            url: url,
            type: method,
            data: data,
            dataType: type,
            //contentType: 'application/json',
            async: false,
            success: function(data) {
                result = jQuery.parseJSON(data);
            },
            error: function(xhr){
                console.log(xhr.responseText);
                result = jQuery.parseJSON(xhr.responseText);
            },
        });
        return result;
    }
});
