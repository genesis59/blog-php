<?php

declare(strict_types=1);

namespace App\Model\Repository;

use App\Enum\Role;
use App\Model\Entity\Article;

/**
 * @template T of object
 * @extends BaseRepository<T>
 */
class ArticleRepository extends BaseRepository
{
    /**
     * @var class-string<T>
     */
    protected string $class = Article::class;

    /**
     * @param T $entity
     * @return bool
     */
    public function create(object $entity): bool
    {
        if (!$entity instanceof Article || $entity->getUser()->getRoleUsers() === Role::USER) {
            return false;
        }
        $sql = 'INSERT INTO ' . $this->getClassName() . '(title,chapo,content,created_at,updated_at,id_user) VALUES (:title,:chapo,:content,NOW(),NOW(),:idUser)';
        $this->database->prepare($sql);
        $this->database->execute(['title' => $entity->getTitle(), 'chapo' => $entity->getChapo(), 'content' => $entity->getContent(),'idUser' => $entity->getUser()->getId()]);
        return true;
    }

    /**
     * @param T $entity
     * @return bool
     */
    public function update(object $entity): bool
    {
        if (!$entity instanceof Article || !$this->findOneBy(['id' => $entity->getId()])) {
            return false;
        }
        $sql = 'UPDATE ' . $this->getClassName() . ' SET title = :title, chapo = :chapo, content = :content, id_user = :idUser, updated_at = NOW() WHERE id = :id';
        $this->database->prepare($sql);
        $this->database->execute(['id' => $entity->getId(), 'title' => $entity->getTitle(), 'content' => $entity->getContent(), 'chapo' => $entity->getChapo(), 'idUser' => $entity->getUser()->getId()]);
        return true;
    }
}
