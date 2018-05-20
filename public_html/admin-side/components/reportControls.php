<nav class="navbar fixed-bottom navbar-light bg-dark" id="reportControls">
  <button type="button"
          class="btn btn-danger btn-sm"
          float="right"
          data-toggle="modal"
          data-target="#editFiltersModal">
    <?php include("../images/Octicons/settings.svg"); ?>
    <div class="reportControlsText">Adjust Report Filters</div>
  </button>
  <div class="float-right">
    <a type="button"
            class="btn btn-success btn-sm"
            float="right"
            id="csvBtn">
      <?php include("../images/Octicons/desktop-download.svg"); ?>
      <div class="reportControlsText">Download Table as .CSV File</div>
    </a>
    <a type="button"
            class="btn btn-success btn-sm"
            float="right"
            target="_blank"
            id="pngBtn">
      <?php include("../images/Octicons/file-media.svg"); ?>
      <div class="reportControlsText">View Chart as .PNG File</div>
    </a>
  </div>
</nav>
