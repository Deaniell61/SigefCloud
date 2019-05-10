var products = {
    getProduct: function (mCallback, mMasterSKU) {
        $.ajax({
            url:'../php/objects/productsRequests.php',
            type:'POST',
            data:{
                method:'getProduct',
                masterSKU: mMasterSKU,
            },
            success: function (response) {
                var tResponse = JSON.parse(response);
                // console.log(tResponse);
                mCallback(tResponse);
            },
            error: function (response) {
                console.log('E' + JSON.stringify(response));
            }
        });

        return 'tr';
    }
}