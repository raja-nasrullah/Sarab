<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReservationController extends Controller
{
    public function adminIndex()
    {
        // Fetch all reservations with their related customer and table, ordered by newest first
        $reservations = Reservation::with('customer', 'table')
                        ->orderBy('reservation_date', 'desc')
                        ->get();

        // Return the admin view
        return view('admin.pages.reservation.reservation', compact('reservations'));
    }
    public function index()
    {
        $reservations = Reservation::with('customer', 'table')->get();
        return response()->json($reservations);
    }
    public function store(Request $request)
    {
        // 1. Validate the form data from the public website
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'guests' => 'required|integer|min:1',
            'reservation_date' => 'required|date|after_or_equal:today',
            'reservation_time' => 'required',
            'table_id' => 'nullable|exists:restaurant_tables,id', // ✅ Added validation for table
            'request' => 'nullable|string|max:500',
        ]);

        // 2. Find or create the Customer using the email
        $customer = \App\Models\Customer::firstOrCreate(
            ['email' => $request->email],
            [
                'name' => $request->name,
                'phone' => $request->phone,
            ]
        );

        // 3. Create the Reservation linked to the customer's ID
        $reservation = Reservation::create([
            'customer_id' => $customer->id,
            'table_id' => $request->table_id, // ✅ Save the selected table
            'reservation_date' => $request->reservation_date,
            'reservation_time' => $request->reservation_time,
            'guests' => $request->guests,
            'status' => 'pending',
        ]);

        // 4. Redirect back with a success message
        return redirect()->route('reservation')->with('success', 'Your table has been reserved! We will confirm shortly.');
    }

    public function show($id)
    {
        $reservation = Reservation::with('customer', 'table')->find($id);
        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }
        return response()->json($reservation);
    }

    public function update(Request $request, $id)
    {
        $reservation = Reservation::find($id);
        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        $request->validate([
            'reservation_date' => 'sometimes|date|after_or_equal:today',
            'reservation_time' => 'sometimes',
            'guests' => 'sometimes|integer|min:1',
            'status' => 'sometimes|in:pending,confirmed,cancelled',
        ]);

        $reservation->update($request->all());
        return response()->json($reservation);
    }

    public function destroy($id)
    {
        $reservation = Reservation::find($id);
        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found'], 404);
        }

        $reservation->delete();
        return response()->json(['message' => 'Reservation deleted successfully']);
    }
    // Show the add reservation form
    public function addreservation()
    {
        // Get all customers and tables for the dropdowns
        $customers = \App\Models\Customer::all();
        $tables = \App\Models\RestaurantTable::all();
        
        return view('admin.pages.reservation.addreservation', compact('customers', 'tables'));
    }

// Store the reservation from the admin panel
    public function storeAddreservation(Request $request)
    {
        $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'table_id' => 'nullable|exists:restaurant_tables,id',
            'reservation_date' => 'required|date|after_or_equal:today',
            'reservation_time' => 'required',
            'guests' => 'required|integer|min:1',
            'status' => 'sometimes|in:pending,confirmed,cancelled',
        ]);

        Reservation::create($request->all());

        return redirect()->route('admin.reservations')->with('success', 'Reservation added successfully!');
    }
// Show the edit reservation form
    public function editreservation($id)
    {
        $reservation = Reservation::findOrFail($id);
        $customers = \App\Models\Customer::all();
        $tables = \App\Models\RestaurantTable::all();
        
        return view('admin.pages.reservation.editreservation', compact('reservation', 'customers', 'tables'));
    }

// Update the reservation from the admin panel
    public function updateEditreservation(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'table_id' => 'nullable|exists:restaurant_tables,id',
            'reservation_date' => 'required|date|after_or_equal:today',
            'reservation_time' => 'required',
            'guests' => 'required|integer|min:1',
            'status' => 'sometimes|in:pending,confirmed,cancelled',
        ]);

        $reservation->update($request->all());

        return redirect()->route('admin.reservations')->with('success', 'Reservation updated successfully!');
    }
// Delete a reservation from the admin panel
    public function destroyReservation($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return redirect()->route('admin.reservations')->with('success', 'Reservation deleted successfully!');
    }

    // 👇 ADD THIS METHOD FOR THE PUBLIC WEBSITE RESERVATION PAGE
    public function websiteIndex()
    {
        // 1. Fetch all available tables
        $tables = \App\Models\RestaurantTable::all();

        // 2. Return the public website view
        return view('website.pages.reservation', compact('tables'));
    }
        // ✅ NEW METHOD: Export Reservations to CSV
    public function exportCsv()
    {
        // Fetch all reservations with their related customer and table
        $reservations = \App\Models\Reservation::with('customer', 'table')
                        ->orderBy('created_at', 'desc')
                        ->get();

        // Set the headers to force download of a CSV file
        $fileName = 'reservations_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        // Create a callback that outputs the CSV data
        $callback = function() use ($reservations) {
            $file = fopen('php://output', 'w');
            
            // Add the column headers
            fputcsv($file, ['ID', 'Customer Name', 'Customer Email', 'Table Number', 'Reservation Date', 'Reservation Time', 'Guests', 'Status', 'Created At']);

            // Loop through the reservations and add rows
            foreach ($reservations as $reservation) {
                fputcsv($file, [
                    $reservation->id,
                    $reservation->customer ? $reservation->customer->name : 'Guest',
                    $reservation->customer ? $reservation->customer->email : 'N/A',
                    $reservation->table ? $reservation->table->table_number : 'N/A',
                    \Carbon\Carbon::parse($reservation->reservation_date)->format('Y-m-d'),
                    \Carbon\Carbon::parse($reservation->reservation_time)->format('H:i A'),
                    $reservation->guests,
                    $reservation->status,
                    $reservation->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            fclose($file);
        };

        // Return the CSV file as a downloadable stream
        return response()->stream($callback, 200, $headers);
    }

        public function getReservationsData(Request $request)
    {
        $reservations = Reservation::with(['customer', 'table'])->orderBy('created_at', 'desc');

        return DataTables::of($reservations)
            // ✅ 1. Map the 'customer' column
            ->addColumn('customer', function ($reservation) {
                if (!$reservation->customer) {
                    return '<span class="text-muted">Guest</span>';
                }
                $initial = substr($reservation->customer->name, 0, 2);
                return '<div style="display:flex;align-items:center;gap:8px;">
                            <div style="width:32px;height:32px;border-radius:50%;background:#3498db;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:600;font-size:12px;">' . $initial . '</div>
                            <span style="font-weight:500;">' . $reservation->customer->name . '</span>
                        </div>';
            })

            // ✅ 2. Map the 'table' column
            ->addColumn('table', function ($reservation) {
                return $reservation->table ? $reservation->table->table_number : '<span class="text-muted">N/A</span>';
            })

            // ✅ 3. Map the 'action' column (Edit and Delete)
            ->addColumn('action', function ($reservation) {
                $editBtn = '<a href="' . route('admin.editreservation', $reservation->id) . '" class="tb-btn" aria-label="Edit" title="Edit">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                                <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>';

                $deleteForm = '<form action="' . route('admin.reservation.destroy', $reservation->id) . '" method="POST" class="inline" onsubmit="return confirm(\'Are you sure you want to permanently delete this reservation?\');">
                            <input type="hidden" name="_token" value="' . csrf_token() . '">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="tb-btn" style="color:var(--red);" aria-label="Delete" title="Delete">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                                    <path d="M3 6h18M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/>
                                </svg>
                            </button>
                        </form>';

                return '<div style="display:flex;justify-content:flex-end;gap:6px;">' . $editBtn . $deleteForm . '</div>';
            })

            // ✅ 4. Format the 'status' column
            ->editColumn('status', function ($reservation) {
                $bg = $reservation->status == 'confirmed' ? '#28a74520' : ($reservation->status == 'pending' ? '#ffc10720' : '#dc354520');
                $color = $reservation->status == 'confirmed' ? '#28a745' : ($reservation->status == 'pending' ? '#ffc107' : '#dc3545');
                return '<span style="background:' . $bg . ';color:' . $color . ';padding:4px 12px;border-radius:12px;font-size:11px;font-weight:600;">' . ucfirst($reservation->status) . '</span>';
            })

            // ✅ 5. Format dates and times
            ->editColumn('reservation_date', function ($reservation) {
                return \Carbon\Carbon::parse($reservation->reservation_date)->format('M d, Y');
            })
            ->editColumn('reservation_time', function ($reservation) {
                return \Carbon\Carbon::parse($reservation->reservation_time)->format('h:i A');
            })

            // ✅ 6. Allow HTML in specific columns (so the styling works)
            ->rawColumns(['customer', 'status', 'action', 'table'])
            ->make(true);
    }
}
