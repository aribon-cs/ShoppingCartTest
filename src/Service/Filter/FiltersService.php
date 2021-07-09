<?php


namespace App\Service\Filter;


use App\Filter\QueryFilterInterface;
use App\Repository\FilterableRepositoryInterface;
use App\Transformer\TransformerInterface;
use Doctrine\ORM\Query;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class FiltersService implements FilterServiceInterface
{

    private TransformerInterface $paginateTransformer;
    private PaginatorInterface $paginator;
    private ?Request $request;
    private ?Query $query;
    private int $page;
    private int $perPage;

    public function __construct(PaginatorInterface $paginator,RequestStack $request, TransformerInterface $paginateTransformer)
    {
        $this->paginator = $paginator;
        $this->request = $request->getCurrentRequest();
        $this->paginateTransformer = $paginateTransformer;
    }

    public function setPageConfig(): void
    {
        if (!is_null($this->request)) {
            $this->page = $this->request->query->getInt('page', 1);
            $this->perPage = $this->request->query->getInt('perPage', 25);
        }
    }
    public function paginate(): PaginationInterface
    {
        $this->setPageConfig();
        return $this->paginator->paginate(
            $this->query,
            $this->page,
            $this->perPage
        );
    }

    /**
     * @param TransformerInterface $serviceTransformer
     * @param string $paginatorType type of transformer such as <b>'paginator' | 'full' | 'simple'</b>
     * @param array $extra
     * @return array
     */
    public function paginateWithTransformer(TransformerInterface $serviceTransformer, string $paginatorType = 'simple', array $extra = []): array
    {
        $paginates = $this->paginate();

        return array_merge(
            $this->paginateTransformer->simpleTransformModel($paginates),
            ['items' => array_merge(
                ['data' => call_user_func([$serviceTransformer, 'transformArrayObject'], $paginates->getItems(), $paginatorType)],
                $extra
            ),
            ]
        );
    }

    /**
     * @param Query $query
     * @return $this
     */
    public function setQuery(Query $query)
    {
        $this->query = $query;

        return $this;
    }

    /**
     * @param FilterableRepositoryInterface $repository
     * @param QueryFilterInterface $filter
     * @return $this
     */
    public function getByQueryFilter(FilterableRepositoryInterface $repository, QueryFilterInterface $filter)
    {
        $this->query = $repository->getQueryByQueryFilter($filter, $this->request->query->all());

        return $this;
    }

}