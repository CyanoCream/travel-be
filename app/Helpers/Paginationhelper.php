<?php

namespace App\Helpers;


class PaginationHelper
{
    /**
     * Menghitung total halaman berdasarkan total data dan limit per halaman.
     * @param int $total
     * @param int|null $limit
     * @return int
     */
    public static function getTotalPages($total, $limit)
    {
        if ($limit == null) {
            return  1;
        }
        return max((int) ceil($total / $limit), 1); // Minimal harus ada 1 halaman
    }

    /**
     * Menghitung halaman saat ini berdasarkan offset dan limit.
     * @param int $offset
     * @param int|null $limit
     * @param int $totalPages
     * @return int
     */
    public static function getCurrentPage($offset,  $limit,  $totalPages)
    {
        if ($limit == null) {
            return  1;
        }
        return min((int) floor($offset / $limit) + 1, $totalPages); // Cegah currentPage > totalPages
    }

    /**
     * Mengambil data dari database berdasarkan offset dan limit.
     * @param mixed $model
     * @param int $offset
     * @param int|null $limit
     * @param int $total
     * @return Collection|array
     */
    public static function getData($model, $offset, $limit, $total)
    {
        // Ubah ke Collection jika belum berbentuk Collection
        $collection = collect($model);

        // Jika limit null, ambil semua data mulai dari offset
        if ($limit === null) {
            return $collection->slice($offset)->values()->all();
        }

        // Jika limit ada, lakukan pagination dengan slice()
        return ($offset < $total) && $limit > 0
            ? $collection->slice($offset, $limit)->values()->all()
            : [];
    }

}
