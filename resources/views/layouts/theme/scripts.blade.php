<script src="{{ asset('vendor/global/global.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('vendor/chart.js/Chart.bundle.min.js') }}"></script>

<script src="{{ asset('vendor/peity/jquery.peity.min.js') }}"></script>

{{-- <script src="{{ asset('vendor/apexchart/apexchart.js') }}"></script>

<script src="{{ asset('js/dashboard/dashboard-2.js') }}"></script> --}}

<script src="{{ asset('js/custom.min.js') }}"></script>

<script src="{{ asset('js/deznav-init.js') }}"></script>


<script src="{{ asset('vendor/toastr/js/toastr.min.js') }}"></script>

<script src="{{ asset('js/sweetalert2.min.js') }}"></script>

<script src="{{ asset('js/tom-select.complete.min.js') }}"></script>

<script src="{{ asset('js/notify.min.js') }}"></script>

<script src="{{ asset('js/slick-loader.min.js') }}"></script>

<script>
    //full loaded
    window.addEventListener('load', () => {

        document.addEventListener('ok', (event) => {
            Swal.fire({
                title: "<span style='color:orange'>"+ "info" + "</span>",
                html: event.detail.msg,
                timer: 3000,
                showConfirmButton: !1,
            }).then((result) => {
                // do something
            })
        })


        document.addEventListener('noty-error', (event) => {
            toastr.error(event.detail.msg, "Info",{
                positionClass: "toast-bottom-center",
                closeButton: !0,
                progressBar: !0, 
            })
        })

        document.addEventListener('noty', (event) => {
            toastr.info(event.detail.msg, "Info",{
                positionClass: "toast-bottom-center",
                closeButton: !0,
                progressBar: !0, 
            })
        })

    })

function showProcessing() {
    SlickLoader.setText('ESPERA','PROCESANDO SOLICITUD')
    SlickLoader.enable()
}


function hideProcessing() {    
    SlickLoader.disable()
}



function Confirm(componentName, rowId) {
    Swal.fire({
    title: '¿CONFIRMAS ELIMINAR EL REGISTRO?',
    text: "",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Aceptar'
    }).then((result) => {
    if (result.value) {
        showProcessing()
        window.livewire.emitTo(componentName, 'Destroy', rowId)
    }
    })
    }

</script>