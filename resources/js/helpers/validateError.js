export function catchValidate(error) {
    var errors = [];
    if (error.response.data.errors) {
        var errorObj = error.response.data.errors;
        for (var key in errorObj) {
            for (var i = 0; i < errorObj[key].length; i++) {
                errors.push(errorObj[key][i]);
            }
        }
    } else {
        errors.push(error.response.data);
    }

    return errors;
}

export function checkFieldIsEmpty(form) {

    var errors = [];

    for(var key in form) {
        if(!form[key]) {
          errors.push(capitalizeFirstLetter(key) + " field is required");
        }
    }

    return errors;
}

function capitalizeFirstLetter(str) {
    return str.charAt(0).toUpperCase() + str.slice(1)
}