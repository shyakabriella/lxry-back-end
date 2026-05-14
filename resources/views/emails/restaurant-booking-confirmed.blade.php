<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Restaurant Booking Confirmation</title>
</head>

<body style="margin:0; padding:0; background:#f7f1e6; font-family:Arial, Helvetica, sans-serif; color:#1f2937;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#f7f1e6; padding:30px 12px;">
    <tr>
        <td align="center">

            <table width="100%" cellpadding="0" cellspacing="0" style="max-width:720px; background:#ffffff; border-radius:24px; overflow:hidden; box-shadow:0 20px 45px rgba(15,23,42,0.14);">

                <!-- Header -->
                <tr>
                    <td style="background:linear-gradient(135deg,#050505,#2b2115); padding:36px 28px; text-align:center;">
                        <div style="display:inline-block; background:#b4945a; color:#ffffff; padding:9px 18px; border-radius:999px; font-size:12px; letter-spacing:2px; text-transform:uppercase; font-weight:bold;">
                            Booking Confirmed
                        </div>

                        <h1 style="margin:18px 0 8px; color:#ffffff; font-size:30px; line-height:1.25;">
                            Thank you, {{ $customerName ?? 'Customer' }} 🎉
                        </h1>

                        <p style="margin:0; color:#e5d7bd; font-size:15px; line-height:1.7;">
                            Your restaurant order / table booking has been received successfully.
                        </p>
                    </td>
                </tr>

                <!-- Booking Code -->
                <tr>
                    <td style="padding:26px 28px 10px;">
                        <table width="100%" cellpadding="0" cellspacing="0" style="background:#faf7f0; border:1px solid #e5d7bd; border-radius:18px;">
                            <tr>
                                <td style="padding:20px;">
                                    <p style="margin:0 0 6px; color:#64748b; font-size:13px; font-weight:bold; text-transform:uppercase; letter-spacing:1px;">
                                        Booking Code
                                    </p>

                                    <h2 style="margin:0; color:#0f172a; font-size:26px;">
                                        {{ $bookingCode ?? 'N/A' }}
                                    </h2>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- Greeting -->
                <tr>
                    <td style="padding:14px 28px 6px;">
                        <p style="margin:0; font-size:15px; line-height:1.8; color:#334155;">
                            Dear <strong>{{ $customerName ?? 'Customer' }}</strong>,
                            we are happy to confirm that your
                            <strong>
                                {{ ($bookingType ?? '') === 'buy_now' ? 'Buy Now order' : 'table booking' }}
                            </strong>
                            has been received. Our team will review and prepare everything carefully for you.
                        </p>
                    </td>
                </tr>

                <!-- Booking Details -->
                <tr>
                    <td style="padding:18px 28px;">
                        <h3 style="margin:0 0 12px; color:#0f172a; font-size:18px;">
                            Booking Details
                        </h3>

                        <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse; border:1px solid #e5d7bd; border-radius:14px; overflow:hidden;">
                            <tr>
                                <td style="padding:13px 15px; background:#faf7f0; color:#64748b; font-size:13px; font-weight:bold; width:40%;">
                                    Customer Name
                                </td>
                                <td style="padding:13px 15px; color:#0f172a; font-size:13px;">
                                    {{ $booking->customer_name ?? 'N/A' }}
                                </td>
                            </tr>

                            <tr>
                                <td style="padding:13px 15px; background:#ffffff; color:#64748b; font-size:13px; font-weight:bold;">
                                    Phone
                                </td>
                                <td style="padding:13px 15px; color:#0f172a; font-size:13px;">
                                    {{ $booking->phone ?? 'N/A' }}
                                </td>
                            </tr>

                            <tr>
                                <td style="padding:13px 15px; background:#faf7f0; color:#64748b; font-size:13px; font-weight:bold;">
                                    Email
                                </td>
                                <td style="padding:13px 15px; color:#0f172a; font-size:13px;">
                                    {{ $booking->email ?? 'N/A' }}
                                </td>
                            </tr>

                            <tr>
                                <td style="padding:13px 15px; background:#ffffff; color:#64748b; font-size:13px; font-weight:bold;">
                                    Booking Type
                                </td>
                                <td style="padding:13px 15px; color:#0f172a; font-size:13px;">
                                    {{ ($booking->booking_type ?? '') === 'buy_now' ? 'Buy Now' : 'Book Table' }}
                                </td>
                            </tr>

                            <tr>
                                <td style="padding:13px 15px; background:#faf7f0; color:#64748b; font-size:13px; font-weight:bold;">
                                    Payment Method
                                </td>
                                <td style="padding:13px 15px; color:#0f172a; font-size:13px;">
                                    {{ ucfirst(str_replace('_', ' ', $booking->payment_method ?? 'N/A')) }}
                                </td>
                            </tr>

                            <tr>
                                <td style="padding:13px 15px; background:#ffffff; color:#64748b; font-size:13px; font-weight:bold;">
                                    Payment Status
                                </td>
                                <td style="padding:13px 15px; color:#0f172a; font-size:13px;">
                                    {{ ucfirst($booking->payment_status ?? 'unpaid') }}
                                </td>
                            </tr>

                            @if(!empty($booking->booking_date))
                                <tr>
                                    <td style="padding:13px 15px; background:#faf7f0; color:#64748b; font-size:13px; font-weight:bold;">
                                        Booking Date
                                    </td>
                                    <td style="padding:13px 15px; color:#0f172a; font-size:13px;">
                                        {{ $booking->booking_date }}
                                    </td>
                                </tr>
                            @endif

                            @if(!empty($booking->booking_time))
                                <tr>
                                    <td style="padding:13px 15px; background:#ffffff; color:#64748b; font-size:13px; font-weight:bold;">
                                        Booking Time
                                    </td>
                                    <td style="padding:13px 15px; color:#0f172a; font-size:13px;">
                                        {{ $booking->booking_time }}
                                    </td>
                                </tr>
                            @endif

                            @if(!empty($booking->party_size))
                                <tr>
                                    <td style="padding:13px 15px; background:#faf7f0; color:#64748b; font-size:13px; font-weight:bold;">
                                        Party Size
                                    </td>
                                    <td style="padding:13px 15px; color:#0f172a; font-size:13px;">
                                        {{ $booking->party_size }} people
                                    </td>
                                </tr>
                            @endif
                        </table>
                    </td>
                </tr>

                <!-- Items -->
                <tr>
                    <td style="padding:4px 28px 18px;">
                        <h3 style="margin:0 0 12px; color:#0f172a; font-size:18px;">
                            Your Items
                        </h3>

                        <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse; border:1px solid #e5d7bd; border-radius:14px; overflow:hidden;">
                            <tr>
                                <th align="left" style="padding:12px; background:#2b2115; color:#ffffff; font-size:12px;">
                                    Item
                                </th>
                                <th align="center" style="padding:12px; background:#2b2115; color:#ffffff; font-size:12px;">
                                    Qty
                                </th>
                                <th align="right" style="padding:12px; background:#2b2115; color:#ffffff; font-size:12px;">
                                    Unit Price
                                </th>
                                <th align="right" style="padding:12px; background:#2b2115; color:#ffffff; font-size:12px;">
                                    Total
                                </th>
                            </tr>

                            @forelse($items as $item)
                                @php
                                    $quantity = (int) ($item->quantity ?? 0);
                                    $unitPrice = (float) ($item->unit_price ?? 0);
                                    $lineTotal = (float) ($item->total_price ?? ($quantity * $unitPrice));
                                @endphp

                                <tr>
                                    <td style="padding:12px; border-bottom:1px solid #e5d7bd; color:#0f172a; font-size:13px;">
                                        {{ $item->item_name ?? 'Menu Item' }}
                                    </td>

                                    <td align="center" style="padding:12px; border-bottom:1px solid #e5d7bd; color:#0f172a; font-size:13px;">
                                        {{ $quantity }}
                                    </td>

                                    <td align="right" style="padding:12px; border-bottom:1px solid #e5d7bd; color:#0f172a; font-size:13px;">
                                        RWF {{ number_format($unitPrice) }}
                                    </td>

                                    <td align="right" style="padding:12px; border-bottom:1px solid #e5d7bd; color:#0f172a; font-size:13px; font-weight:bold;">
                                        RWF {{ number_format($lineTotal) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" style="padding:18px; text-align:center; color:#64748b; font-size:13px;">
                                        No items found.
                                    </td>
                                </tr>
                            @endforelse

                            <tr>
                                <td colspan="3" align="right" style="padding:15px; background:#faf7f0; color:#0f172a; font-size:15px; font-weight:bold;">
                                    Subtotal
                                </td>
                                <td align="right" style="padding:15px; background:#faf7f0; color:#0f172a; font-size:15px; font-weight:bold;">
                                    RWF {{ number_format($subtotal ?? 0) }}
                                </td>
                            </tr>

                            <tr>
                                <td colspan="3" align="right" style="padding:15px; background:#2b2115; color:#ffffff; font-size:16px; font-weight:bold;">
                                    Total Amount
                                </td>
                                <td align="right" style="padding:15px; background:#2b2115; color:#b4945a; font-size:18px; font-weight:bold;">
                                    RWF {{ number_format($total ?? 0) }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                @if(!empty($booking->custom_dish) || !empty($booking->notes))
                    <tr>
                        <td style="padding:0 28px 20px;">
                            <table width="100%" cellpadding="0" cellspacing="0" style="background:#fff7ed; border:1px solid #fed7aa; border-radius:16px;">
                                <tr>
                                    <td style="padding:16px;">
                                        <h3 style="margin:0 0 8px; color:#9a3412; font-size:16px;">
                                            Additional Notes
                                        </h3>

                                        @if(!empty($booking->custom_dish))
                                            <p style="margin:0 0 8px; color:#7c2d12; font-size:13px; line-height:1.7;">
                                                <strong>Custom Dish:</strong> {{ $booking->custom_dish }}
                                            </p>
                                        @endif

                                        @if(!empty($booking->notes))
                                            <p style="margin:0; color:#7c2d12; font-size:13px; line-height:1.7;">
                                                <strong>Notes:</strong> {{ $booking->notes }}
                                            </p>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                @endif

                <!-- Footer -->
                <tr>
                    <td style="padding:24px 28px 30px; text-align:center; background:#faf7f0;">
                        <p style="margin:0 0 8px; color:#0f172a; font-size:15px; font-weight:bold;">
                            We look forward to serving you.
                        </p>

                        <p style="margin:0; color:#64748b; font-size:12px; line-height:1.7;">
                            Please keep your booking code for reference. If you need changes, contact our restaurant team.
                        </p>
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>