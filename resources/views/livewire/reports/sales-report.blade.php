<div>
    <span class="text-warning h3">Sales Report</span>
    <div class="row">
        <div class="col-sm-12 col-md-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Panel Options</h4>
                </div>
                <div class="card-body">

                    <div wire:ignore>
                        <label>From Date</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="las fa-calendar"></i></span>
                            </div>
                            <input id="startDate" class="datepicker-default form-control form-control-lg">
                        </div>
                    </div>

                    <div class="mt-2" wire:ignore>
                        <label>To Date</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="las fa-calendar"></i></span>
                            </div>
                            <input id="endDate" class="datepicker-default form-control form-control-lg">
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label>User</label>
                        <select wire:model.defer="selectedUser" class="form-control form-control-lg">
                            <option value="0">All users</option>
                            @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mt-3">
                        <label>Type</label>
                        <select wire:model.defer="reportType" class="form-control form-control-lg">
                            <option value="0">General</option>
                            <option value="1">Top 10</option>
                            <option value="2">Paypal</option>
                        </select>
                    </div>

                </div>
                <div class="card-footer">
                    <button class="btn btn-sm btn-info float-right save" onclick="getReport()">Apply</button>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-9">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex">
                        <div class="mr-auto">
                            <h4 class="card-title">Sales</h4>
                        </div>
                    </div>
                    <div class="float-right">
                        <button class="btn tp-btn-light btn-success btn-xs">
                            <i class="las la-file-pdf la-2x"></i>
                        </button>
                        <button class="btn tp-btn-light btn-success btn-xs" wire:click="Export" {{ count($data)> 0 ? ''
                            : 'disabled' }}>
                            <i class="las la-file-excel la-2x"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if($reportType == 0)
                        @include('livewire.reports.table')
                        @else
                        @include('livewire.reports.tabletop')
                        @endif
                    </div>
                </div>
                <div class="card-footer">

                </div>
            </div>
        </div>
    </div>

    @include('livewire.reports.detail')

    <script>
        document.addEventListener('livewire:load', function () {
        //compactar sidebar
            var mainWrapper = document.getElementById('main-wrapper')        
            mainWrapper.classList.add('menu-toggle')    
       })

        function getReport() {
            var $input = $('#startDate').pickadate()
            var picker = $input.pickadate('picker')
            var sDate = picker.get('select', 'yyyy/mm/dd') // fecha inicial

            var eDate = $('#endDate').pickadate('picker').get('select', 'yyyy/mm/dd') //fecha final


            @this.set('startDate', sDate)
            @this.set('endDate', eDate)

            // @this.endDate = eDate
        }


        window.addEventListener('show-detail', event=> {
            $('#modalDetail').modal('show')
        })
    </script>

    <input type="hidden" id="inputFocus">
</div>