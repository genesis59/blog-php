<?php

declare(strict_types=1);

namespace App\Model\Repository;

use App\Model\Entity\Comment;

/**
 * @template T of object
 * @extends BaseRepository<T>
 */
class CommentRepository extends BaseRepository
{
    /**
     * @var class-string<T>
     */
    protected string $class = Comment::class;

    /**
     * @param T $entity
     * @return bool
     */
    public function create(object $entity): bool
    {
        if (!$entity instanceof Comment) {
            return false;
        }

        $sql = 'INSERT INTO ' . $this->getClassName() . '(content,is_active,created_at,id_user,id_article) VALUES (:content,0,NOW(),:id_user,:id_article)';
        $this->database->prepare($sql);
        $this->database->execute(['content' => $entity->getContent(), 'id_user' => $entity->getUser()->getId(), 'id_article' => $entity->getArticle()->getId()]);
        return true;
    }

    /**
     * @param T $entity
     * @return bool
     */
    public function update(object $entity): bool
    {
        if (!$entity instanceof Comment || !$this->findOneBy(['id' => $entity->getId()])) {
            return false;
        }
        $sql = 'UPDATE ' . $this->getClassName() . ' SET is_active = :isActive, id_user = :idUser WHERE id = :id';
        $this->database->prepare($sql);
        $this->database->execute(['isActive' => $entity->isActive(), 'idUser' => $entity->getUser()->getId(), 'id' => $entity->getId()]);
        return true;
    }
}
