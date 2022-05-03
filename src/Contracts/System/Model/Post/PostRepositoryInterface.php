<?php

namespace Leonidas\Contracts\System\Model\Post;

use Leonidas\Contracts\System\Model\Author\AuthorInterface;
use Leonidas\Contracts\System\Model\Category\CategoryInterface;
use Leonidas\Contracts\System\Model\Post\Status\PostStatusInterface;
use Leonidas\Contracts\System\Model\SoftDeletingRepositoryInterface;
use Leonidas\Contracts\System\Model\Tag\TagInterface;
use WP_Query;

interface PostRepositoryInterface extends SoftDeletingRepositoryInterface
{
    public function select(int $id): ?PostInterface;

    public function whereIds(int ...$ids): PostCollectionInterface;

    public function selectByName(string $name): ?PostInterface;

    public function whereNames(string ...$names): PostCollectionInterface;

    public function whereAuthor(AuthorInterface $author): PostCollectionInterface;

    public function whereAuthorDrafts(AuthorInterface $author): PostCollectionInterface;

    public function whereAuthorAll(AuthorInterface $author): PostCollectionInterface;

    public function whereStatus(PostStatusInterface $status): PostCollectionInterface;

    public function withTag(TagInterface $tags): PostCollectionInterface;

    public function withCategory(CategoryInterface $category): PostCollectionInterface;

    public function find(array $args): PostCollectionInterface;

    public function query(WP_Query $query): PostCollectionInterface;

    public function all(): PostCollectionInterface;

    public function insert(PostInterface $post): void;

    public function update(PostInterface $post): void;
}
