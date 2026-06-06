
plugin.tx_dsljobs_jobs {
  view {
    templateRootPaths.0 = EXT:dsl_jobs/Resources/Private/Templates/
    templateRootPaths.1 = {$plugin.tx_dsljobs_jobs.view.templateRootPath}
    partialRootPaths.0 = EXT:dsl_jobs/Resources/Private/Partials/
    partialRootPaths.1 = {$plugin.tx_dsljobs_jobs.view.partialRootPath}
    layoutRootPaths.0 = EXT:dsl_jobs/Resources/Private/Layouts/
    layoutRootPaths.1 = {$plugin.tx_dsljobs_jobs.view.layoutRootPath}
  }
  persistence {
    storagePid = {$plugin.tx_dsljobs_jobs.persistence.storagePid}
    #recursive = 1
  }
  features {
    #skipDefaultArguments = 1
  }
  mvc {
    #callDefaultActionIfActionCantBeResolved = 1
  }
}

plugin.tx_dsljobs._CSS_DEFAULT_STYLE (
    textarea.f3-form-error {
        background-color:#FF9F9F;
        border: 1px #FF0000 solid;
    }

    input.f3-form-error {
        background-color:#FF9F9F;
        border: 1px #FF0000 solid;
    }

    .tx-dsl-jobs table {
        border-collapse:separate;
        border-spacing:10px;
    }

    .tx-dsl-jobs table th {
        font-weight:bold;
    }

    .tx-dsl-jobs table td {
        vertical-align:top;
    }

    .typo3-messages .message-error {
        color:red;
    }

    .typo3-messages .message-ok {
        color:green;
    }
)

plugin.tx_dsljobs_jobsbrumby < plugin.tx_dsljobs_jobs
plugin.tx_dsljobs_jobscrimmitschau < plugin.tx_dsljobs_jobs

## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder




lib.dsljobs_jobs = COA
lib.dsljobs_jobs {
  15 < tt_content.list.20.dsljobs_jobs
}

lib.dsljobs_jobsbrumby = COA
lib.dsljobs_jobsbrumby {
  15 < tt_content.list.20.dsljobs_jobsbrumby
}

lib.dsljobs_jobscrimmitschau = COA
lib.dsljobs_jobscrimmitschau {
  15 < tt_content.list.20.dsljobs_jobscrimmitschau
}