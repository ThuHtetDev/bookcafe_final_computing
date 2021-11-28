<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RentBookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $rentModel = new \App\RentBook;
        $countRent = $rentModel->rentedBooksList($this->book_id)->count();
        return [
            'id' => (string) $this->book->id,
            'isbn' => $this->book->isbn,
            'name' => $this->book->name,
            'categoryName' => $this->book->category->name,
            'categoryId' => (string) $this->book->category->id,
            'cover' => "http://book-cafe.sitetastingmyanmar.com/storage/user_". $this->book->user_id."/book/front_cover/front_small_".substr($this->book->front_cover, strpos($this->book->front_cover, "_") + 1),
            'rentCount' => (string) $countRent,
            'starCount' => '0',
            'rent_status' => $this->rent_status,
            'returnDate' => [
                'start_date' => \Carbon\Carbon::parse($this->start_date)->format('Y-m-d'),
                'end_date' => \Carbon\Carbon::parse($this->return_date)->format('Y-m-d'),
                'since' => $this->created_at->diffForHumans()
            ],
            'admin_approve' => $this->return_approve == '0' ? 'No' : 'Yes',
            'has_return_now' => $this->has_return == '0' ? 'No' : 'Yes',
            'isAvailable' => $this->book->is_available == '1' ? '1' : '0'
        ];
    }
}
