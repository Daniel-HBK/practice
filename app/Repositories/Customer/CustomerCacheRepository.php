<?php 

namespace App\Repositories\Customer;

use Illuminate\Cache\CacheManager;

class CustomerCacheRepository implements CustomerRepositoryInterface
{
    protected $repo;

    protected $cache;

    const TTL = 1440; # 1 day

    public function __construct(CacheManager $cache, CustomerRepository $repo) {
        $this->repo = $repo;
        $this->cache = $cache;
    }

    public function getCustomers() {
        return $this->cache->remember('customers', self::TTL, function () {
            return $this->repo->getCustomers();
        });
    }

}