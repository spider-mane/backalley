<?php

namespace Leonidas\Library\System\Request\Policy;

use Leonidas\Library\System\Request\Abstracts\ExpectsPostEntityTrait;
use Psr\Http\Message\ServerRequestInterface;
use WebTheory\HttpPolicy\ServerRequestPolicyInterface;
use WP_Post;

class PostEntityTermPolicy implements ServerRequestPolicyInterface
{
    use ExpectsPostEntityTrait;

    protected string $taxonomy;

    /**
     * @var array<int,int>
     */
    protected array $terms = [];

    protected bool $matchAll = false;

    public function __construct(string $taxonomy, int ...$terms)
    {
        $this->taxonomy = $taxonomy;
        $this->terms = $terms;
    }

    /**
     * Get the value of terms
     *
     * @return array
     */
    public function getTerms(): array
    {
        return $this->terms;
    }

    public function addTerm(int $term)
    {
        $this->terms[] = $term;
    }

    /**
     * Get the value of matchAll
     *
     * @return bool
     */
    public function shouldMatchAll(): bool
    {
        return $this->matchAll;
    }

    /**
     * Set the value of matchAll
     *
     * @param bool $matchAll
     *
     * @return $this
     */
    public function setMatchAll(bool $matchAll)
    {
        $this->matchAll = $matchAll;

        return $this;
    }

    public function approvesRequest(ServerRequestInterface $request): bool
    {
        $post = $this->getPost($request);

        return $this->matchAll ?
            $this->matchesAllTerms($post) :
            $this->matchesSingleTerm($post);
    }

    protected function matchesSingleTerm(WP_Post $post): bool
    {
        foreach ($this->terms as $term) {
            if (has_term($term, $this->taxonomy, $post)) {
                return true;
            }
        }

        return false;
    }

    protected function matchesAllTerms(WP_Post $post): bool
    {
        foreach ($this->terms as $term) {
            if (!has_term($term, $this->taxonomy, $post)) {
                return false;
            }
        }

        return true;
    }
}