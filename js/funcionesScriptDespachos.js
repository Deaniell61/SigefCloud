var despachos = {
    toggleList: function (mTag) {
        $('#'+mTag).toggle();
    },

    loadRegister: function (mProy, mForm, mList) {
        $('#'+mForm).hide();
        $('#'+mList).show();
    }
};

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}