<?php

namespace App\Services;

use App\Models\Blog;
use Illuminate\Support\Facades\DB;

class BlogService
{

    // public function getAllBlog($id)
    // {
    //     return Blog::findOrFail($id);
    // }

    public function update_blog($request, $id)
    {
        $blog = Blog::findOrFail($id);
        $blog->blog_name = $request->blog_name;
        $blog->blog_description = $request->blog_description;
        $blog->blog_category_id = $request->blog_category_id;
        $blog->status = $request->status;

        if ($request->hasFile('blog_image')) {
           
            if ($blog->blog_image) {
                $previousImagePath = getcwd().'/uploads/blogs/'.$blog->blog_image;
                if (file_exists($previousImagePath)) {
                    @unlink($previousImagePath);
                }
            }
            $fileNameWithExt = $request->file('blog_image')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('blog_image')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            $path = $request->file('blog_image')->move(getcwd().'/uploads/blogs', $fileNameToStore);
            $blog->blog_image = $fileNameToStore;
        }
        
        $blog->save();
        return $blog;
    }

    public function getAllblog()
    {
        return Blog::with('blog_category')->orderBy('id', 'desc')
            ->paginate(config('constants.ROW_PER_PAGE'));
    }
    

    public function createBlog($request)
    {

        if ($request->hasFile('blog_image')) {
            $fileNameWithExt = $request->file('blog_image')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('blog_image')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            $path = $request->file('blog_image')->move(getcwd().'/uploads/blogs', $fileNameToStore);
            
        } else {
            $fileNameToStore = '';
        }
        
        $blog = new Blog([
            'blog_name' => $request->blog_name,
            'blog_category_id' => $request->blog_category_id,
            'blog_image' => $fileNameToStore,
            'blog_description' => $request->blog_description,
            'status' => $request->status
        ]);

        $blog->save();
        return $blog;

    }

    public function get_blog_details($id)
    {
        return Blog::findOrFail($id);
    }


    public function delete_blog($id)
    {
        $blog = Blog::findOrFail($id);
        if ($blog->blog_image) {
            $imagePath = getcwd().'/uploads/blogs/'.$blog->blog_image;
            if (file_exists($imagePath)) {
                @unlink($imagePath);
            }
        }

        if($blog->delete()) {
            return true;
        }
        return false;
    }
}

