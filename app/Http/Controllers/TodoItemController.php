<?php

namespace App\Http\Controllers;

use App\Models\TodoItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TodoItemController extends Controller
{
    //

    public function index()
    {
        $user = Auth::user();
        return response()->json($user->todoItems);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = Auth::user();

        $todoItem = new TodoItem([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        $user->todoItems()->save($todoItem);

        return response()->json(['message' => 'Todo item created successfully']);
    }

    public function show($id)
    {
        $todoItem = TodoItem::find($id);

        if (!$todoItem) {
            return response()->json(['error' => 'Todo item not found'], 404);
        }

        return response()->json($todoItem);
    }

    public function update(Request $request, $id)
    {
        $todoItem = TodoItem::find($id);

        if (!$todoItem) {
            return response()->json(['error' => 'Todo item not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $todoItem->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return response()->json(['message' => 'Todo item updated successfully']);
    }

    public function destroy($id)
    {
        $todoItem = TodoItem::find($id);

        if (!$todoItem) {
            return response()->json(['error' => 'Todo item not found'], 404);
        }

        $todoItem->delete();

        return response()->json(['message' => 'Todo item deleted successfully']);
    }

}
