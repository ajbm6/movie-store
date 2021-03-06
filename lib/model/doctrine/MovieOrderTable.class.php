<?php

/**
 * MovieOrderTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class MovieOrderTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return MovieOrderTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('MovieOrder');
    }

    public function findUserOrders($user)
    {
        $q = $this
            ->createQuery('o')
            ->where('o.user_id = ?', $user)
            ->orderBy('o.created_at DESC')
        ;

        return $q->execute();
    }

    public function findOrder($reference)
    {
        $q = $this
            ->createQuery('o')
            ->leftJoin('o.Items i')
            ->leftJoin('i.Movie m')
            ->where('o.reference = ?', $reference)
        ;

        return $q->fetchOne();
    }

    public function newOrder(array $cart)
    {
        $movies = Doctrine_Query::create()
            ->from('Movie m')
            ->whereIn('m.id', array_keys($cart))
            ->execute()
        ;

        $order = new MovieOrder();
        $order->setMovies($movies);
        $order->setCart($cart);
        $order->init();

        return $order;
    }
}