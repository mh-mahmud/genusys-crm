<div class="tab-pane fade {{ session('active_tab') === 'g_lead_tickets_tab' ? 'active show' : '' }}"
        id="g_lead_tickets" role="tabpanel" aria-labelledby="g_lead_tickets_tab">
    <div class="card">
        <div class="card-body">
            <div id="loader"
                    style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255, 255, 255, 0.8); display: none; justify-content: center; align-items: center; z-index: 10;">
                <svg class="loader" width="50" height="50" viewBox="0 0 50 50">
                    <circle class="loader-circle" cx="25" cy="25" r="20" fill="none"
                            stroke-width="4"></circle>
                </svg>
            </div>
            <button class="btn btn-success btn-sm" id="createTicketButton">Create Ticket</button>
            <button class="btn btn-success btn-sm" id="ticketListBtn">Ticket List</button>
            <div id="ticketIframeContainer" style="margin-top: 20px; display: none;">
                <iframe
                    id="ticketIframe"
                    src=""
                    style="width: 100%; height: 600px; border: none;"
                    title="Create Ticket">
                </iframe>
            </div>
            <table id="ticketTable"
                    class="table table-sm table-condensed table-bordered table-row-gray-100 align-middle gs-0 gy-3 mt-1">
                <!--begin::Table head-->
                <thead>
                <tr class="fw-bolder text-muted bg-light bd-cyan">
                    <th class="min-w-150px">Ticket ID</th>
                    <th class="min-w-150px"> Title</th>
                    <th class="min-w-150px"> Group</th>
                    <th class="min-w-150px"> Status</th>

                </tr>
                </thead>

                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>