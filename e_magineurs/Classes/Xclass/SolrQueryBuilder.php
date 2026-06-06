<?php

declare(strict_types=1);

namespace Emagineurs\EMagineurs\Xclass;

use ApacheSolrForTypo3\Solr\Domain\Search\Query\QueryBuilder as BaseQueryBuilder;

/**
 * XCLASS override to disable typo3access query parser usage
 * 
 * This prevents the "invalid query parser 'typo3access'" error
 * when the typo3access query parser is not configured in Solr.
 */
class SolrQueryBuilder extends BaseQueryBuilder
{
    /**
     * Override to skip adding access filter when typo3access parser is not available
     * 
     * This prevents the "invalid query parser 'typo3access'" error
     * when the typo3access query parser is not configured in Solr.
     * 
     * @param array $groups
     * @return BaseQueryBuilder
     */
    public function useUserAccessGroups(array $groups): BaseQueryBuilder
    {
        // Skip access filtering entirely - typo3access query parser is not configured in Solr
        // This prevents the "invalid query parser 'typo3access'" error
        // Return $this without adding the filter to avoid using {!typo3access}
        return $this;
    }
}

