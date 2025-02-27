<?php

namespace Leonidas\Library\System\Model\Image;

use Leonidas\Contracts\System\Model\Image\ImageCollectionInterface;
use Leonidas\Contracts\System\Model\Image\ImageInterface;
use Leonidas\Contracts\System\Model\Image\ImageRepositoryInterface;
use Leonidas\Contracts\System\Model\Post\PostInterface;
use Leonidas\Library\System\Model\Abstracts\Attachment\AbstractAttachmentEntityRepository;

class ImageRepository extends AbstractAttachmentEntityRepository implements ImageRepositoryInterface
{
    public function fromGlobalQuery(): ImageCollectionInterface
    {
        return $this->manager->fromGlobalQuery();
    }

    public function select(int $id): ?ImageInterface
    {
        return $this->manager->byId($id);
    }

    public function whereIds(int ...$ids): ImageCollectionInterface
    {
        return $this->manager->whereIds(...$ids);
    }

    public function whereAttachedToPost(PostInterface $post): ImageCollectionInterface
    {
        return $this->manager->whereAttachedToPost($post->getId());
    }

    public function query(array $args): ImageCollectionInterface
    {
        return $this->manager->query($args);
    }

    public function all(): ImageCollectionInterface
    {
        return $this->manager->all();
    }

    public function insert(ImageInterface $image): void
    {
        $this->manager->insert($this->extractData($image));
    }

    public function update(ImageInterface $image): void
    {
        $this->manager->update($image->getId(), $this->extractData($image));
    }

    protected function extractData(ImageInterface $image): array
    {
        $dateFormat = $image::DATE_FORMAT;

        $image->applyFilter('db');

        return [
            'post_author' => $image->getAuthor()->getId(),
            'post_date' => $image->getDate()->format($dateFormat),
            'post_date_gmt' => $image->getDate()->format($dateFormat),
            'post_content' => $image->getDescription(),
            'post_title' => $image->getTitle(),
            'post_excerpt' => $image->getCaption(),
            'comment_status' => $image->getCommentStatus(),
            'ping_status' => $image->getPingStatus(),
            'pinged' => $image->getPinged(),
            'to_ping' => $image->getToBePinged(),
            'post_password' => $image->getPassword(),
            'post_name' => $image->getName(),
            'post_modified' => $image->getDate()->format($dateFormat),
            'post_modified_gmt' => $image->getDate()->format($dateFormat),
            'post_mime_type' => $image->getMimeType(),
            'menu_order' => $image->getMenuOrder(),
            'guid' => $image->getGuid()->getHref(),
            '_wp_attachment_image_alt' => $image->getAlt(),
        ];
    }
}
