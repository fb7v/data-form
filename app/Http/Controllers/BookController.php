<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Book;
use Illuminate\Support\Str;

class BookController extends Controller
{
    // Funkcija upload(request)
    // augšupielādē datus no XML faila
    public function upload(Request $request)
    {
        // Validē un glabā xml failu
        $request->validate([
            'file' => 'required|file|mimes:xml|max:2048',
        ]);
        $uploadedFile = $request->file('file');
        $fileName = time().'_'.str_replace(' ', '_', $uploadedFile->getClientOriginalName());
        $uploadedFile->storeAs('xml_files', $fileName);

        $xml = simplexml_load_file(storage_path("app/xml_files/{$fileName}"));

        // Datu pievienošana
        foreach ($xml->book as $xmlBook) {
            try {
                $newBook = [
                    'id' => $this->generateBookId(),
                    'title' => (string) $xmlBook->title,
                    'author' => (string) $xmlBook->author,
                    'genre' => (string) $xmlBook->genre,
                    'price' => (float) $xmlBook->price,
                    'publish_date' => (string) $xmlBook->publish_date,
                    'description' => (string) $xmlBook->description,
                ];
                info("New Book Data: " . json_encode($newBook));
                Book::create($newBook);

            } catch (\Exception $e) {
                info("Exception: " . $e->getMessage());
            }
        }
        return redirect('/')->with('success', 'Data uploaded succesfully');
    }

    // Funkcija generateBookId()
    // Ģenerē unikālu ID nākamajai grāmatai
    protected function generateBookId()
    {
    $idPrefix = 'bk';
    $lastBook = Book::orderBy('id', 'desc')->first();

    if ($lastBook) {
        $lastNumber = intval(substr($lastBook->id, strlen($idPrefix)));
        $newNumber = $lastNumber + 1;
    } else {
        $newNumber = 101; // Sākuma id ja nav grāmatu
    }

    return $idPrefix . $newNumber;
    }

    // Funkcija update(request, id)
    // Atjauno ierakstu ar datiem no Request
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:150',
            'author' => 'required|string|max:150',
            'genre' => 'required|string|max:30',
            'price' => 'required|numeric',
            'publish_date' => 'required|date',
            'description' => 'required|string|max:300',
        ]);

        try {
            // Lieto jau eksistējošu ID kas padots no Request
            $book = Book::find($id);
            if (!$book) {
                return response()->json(['error' => 'Book not found'], 404);
            }

            $book->update($request->all());
            
            info("Updated Book Data: " . json_encode($book));
            return response()->json(['success' => true, 'editedData' => $book, 'message' => 'Book updated successfully']);
        } catch (\Exception $e) {
            info("Exception: " . $e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error updating book']);
        }
    }

    // Funkcija store(request)
    // Izveido jaunu ierakstu ar jaunu ID
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:150',
            'author' => 'required|string|max:150',
            'genre' => 'required|string|max:30',
            'price' => 'required|numeric',
            'publish_date' => 'required|date',
            'description' => 'required|string|max:300',
        ]);

        try {
            $newBook = Book::create([
                'id' => $this->generateBookId(),
                'title' => $request->input('title'),
                'author' => $request->input('author'),
                'genre' => $request->input('genre'),
                'price' => $request->input('price'),
                'publish_date' => $request->input('publish_date'),
                'description' => $request->input('description'),
            ]);

            return response()->json(['message' => 'Book created successfully', 'editedData' => $newBook, 'id' => $newBook->id], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error creating book', 'message' => $e->getMessage()], 500);
        }
    }

    // Funkcija index()
    // attēlo view index ar tabulu books
    public function index()
    {
        $books = Book::orderBy('id')->get();
        return view('index', compact('books'));
    }
}