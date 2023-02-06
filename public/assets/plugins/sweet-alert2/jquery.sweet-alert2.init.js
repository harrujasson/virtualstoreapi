/**
 * Theme: Ubold Template
 * Author: Coderthemes
 * SweetAlert
 */

! function($) {
    "use strict";

    var SweetAlert = function() {};

    //examples
    SweetAlert.prototype.init = function() {

            //Delete
            $("body").on("click", '.sa-warning', function() {
                var url = $(this).attr("data-url");
                var msg = $(this).attr("data-msg");
                if (msg === undefined || msg === null) {
                    msg = "You won’t be able to undo this!";
                }
                Swal.fire({
                    title: 'Are you sure?',
                    text: msg,
                    type: 'warning',
                    showCancelButton: true,                   
                    confirmButtonText: 'Yes, delete it!',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then(function() {
                    $.ajax({
                        url: url,
                        success: function(status) {
                            if (status == 1) {
                                swal(
                                    'Deleted!',
                                    'Record has been deleted.',
                                    'success'
                                )
                                setTimeout(function() { location.reload(); }, 1000);

                            } else {
                                Swal.fire(
                                    'Error!',
                                    'Record not deleted.',
                                    'error'
                                )
                            }
                        }
                    });

                })
            });

            //Status Change

            $("body").on("click", '.sa-warning-status', function() {
                var url = $(this).attr("data-url");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Status will be change!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#4fa7f3',
                    cancelButtonColor: '#d57171',
                    confirmButtonText: 'Yes, change it!'
                }).then(function() {
                    $.ajax({
                        url: url,
                        success: function(status) {
                            if (status == 1) {
                                swal(
                                    'Changes!',
                                    'Status has been changed.',
                                    'success'
                                )
                                setTimeout(function() { location.reload(); }, 1000);

                            } else {
                                Swal.fire(
                                    'Error!',
                                    'Status not changed.',
                                    'error'
                                )
                            }
                        }
                    });

                })
            });


        },
        //init
        $.SweetAlert = new SweetAlert, $.SweetAlert.Constructor = SweetAlert
}(window.jQuery),

//initializing
function($) {
    "use strict";
    $.SweetAlert.init()
}(window.jQuery);