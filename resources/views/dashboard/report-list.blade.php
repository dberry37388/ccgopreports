@push('scripts')
    <script>
        $(function() {
            $("#district-select").on('change', function(e) {
                let value = this.value;
                let reportList = $("#reportList");

                if (! value.length) {
                    reportList.hide();
                } else {
                    reportList.show();
                    $("#districtNumber").text(this.value);
                    $("#districtMasterListtUri").attr("href", `/exports/districts/${this.value}/export`);
                    $("#districtHitListUri").attr("href", `/exports/districts/${this.value}/hitlist`);
                }
            });
        });
    </script>
@endpush

<table class="table table-hover">
    <tbody>
    <tr>
        <td>
            <a href="{{ route('exportMasterWalkList') }}">Master Walk List</a>

            <p>Master Walk List, containing all precincts. Current through 5/18.</p>
        </td>
    </tr>

    <tr>
        <td>
            <a href="{{ route('exportMasterRepublicanHitList') }}">Master Republican Hit List</a>

            <p>This is a list of voters who voted Republican in the 5/18 elections, are not first time voters and have never voted Democrat.</p>
        </td>
    </tr>

    <tr>
        <td>
            <a href="{{ route('districtsIndex') }}">{{ __('Districts') }}</a>

            <p>Choose a district from the list below to download that district's walk list.</p>

            <div class="form-group mt-2">
                <select id="district-select" class="form-control">
                    <option value="">Choose a District</option>
                    @for($i = 1; $i <= 21; $i++)
                        <option value="{{ $i }}">District {{ $i }}</option>
                    @endfor
                </select>
            </div>

            <div id="reportList" class="form-group" style="display: none">
                <div class="font-weight-bold">
                    Choose a Report for <span id="districtNumber"></span>
                </div>

                <div class="district-reports">
                    <a id="districtMasterListtUri" href="#">Master List</a> | <a id="districtHitListUri" href="#">Hit List</a>
                </div>
            </div>
        </td>
    </tr>

    <tr>
        <td>
            <a href="{{ route('exportCrossoverList') }}">2018 Crossovers</a>
            <p>List of voters who until the 5/18 primaries have voted Democrat.</p>
        </td>
    </tr>

    <tr>
        <td>
            <a href="{{ route('exportFirstTimeVoterList') }}">First Time Voters (combined parties)</a>
            <p>Voter who the 5/18 primary vote was their first time to vote.</p>
        </td>
    </tr>

    <tr>
        <td>
            <a href="{{ route('exportFirstTimeRepublicanList') }}">First Time Voters - Republican Only</a>
            <p>List of first time voters who voted Republican on 5/18</p>
        </td>
    </tr>

    <tr>
        <td>
            <a href="{{ route('exportFirstTimeDemocratList') }}">First Time Voters - Democrat Only</a>
            <p>List of first time voters who voted Democrat on 5/18</p>
        </td>
    </tr>
    </tbody>
</table>



<h5 class="mb-3 mt-5">Understanding the Columns</h5>

<table class="table table-bordered">
    <thead>
    <tr>
        <th>Column</th>
        <th>Description</th>
    </tr>
    </thead>

    <tbody>
    <tr>
        <td>LNAME</td>
        <td>The voter's last name</td>
    </tr>

    <tr>
        <td>ADDRESS</td>
        <td>The voter's current street address</td>
    </tr>

    <tr>
        <td>PCT</td>
        <td>The voter's precinct</td>
    </tr>

    <tr>
        <td>T</td>
        <td>Total time the voter has participated.</td>
    </tr>

    <tr>
        <td>%</td>
        <td>Percentage of times the voter has voted Republican</td>
    </tr>

    <tr>
        <td>R</td>
        <td>Republican</td>
    </tr>

    <tr>
        <td>D</td>
        <td>Democrat</td>
    </tr>
    </tbody>
</table>
