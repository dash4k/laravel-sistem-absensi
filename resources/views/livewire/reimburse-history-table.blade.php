<div class="mt-8">
    <h2 class="font-bold text-md mt-8">Riwayat Reimbursement</h2>
    <table class="table-fixed w-full text-center text-sm break-words">
        <thead class="bg-blue-600 text-white font-black">
            <tr>
                <th class="border px-4 py-2">Tanggal</th>
                <th class="border px-4 py-2">Jenis</th>
                <th class="border px-4 py-2">Nominal</th>
                <th class="border px-4 py-2">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($reimbursements as $r)
                <tr>
                    <td class="border px-4 py-2 break-words capitalize">{{ $r->created_at->format('d-m-Y') }}</td>
                    <td class="border px-4 py-2 break-words">
                        @if ($r->type === 'bensin')
                            <p class="bg-orange-300 text-black px-2 py-1 rounded" title="Bensin">
                                <i class="fa-solid fa-gas-pump"></i>
                            </p>
                        @elseif ($r->type === 'makan')
                            <p class="bg-lime-300 text-black px-2 py-1 rounded" title="Makan">
                                <i class="fa-solid fa-utensils"></i>
                            </p>
                        @else
                            <p class="bg-indigo-300 text-black px-2 py-1 rounded" title="Barang">
                                <i class="fa-solid fa-box-open"></i>
                            </p>
                        @endif
                    </td>
                    <td class="border px-4 py-2 break-words">Rp. {{ number_format($r->nominal, 0, ',', '.') }}</td>
                    <td class="border px-4 py-2 break-words">
                        @if ($r->status)
                            <p class="bg-green-300 text-black px-2 py-1 rounded" title="Barang">
                                LUNAS
                            </p>
                        @else
                            <p class="bg-red-300 text-black px-2 py-1 rounded" title="Barang">
                                PENDING
                            </p>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="border px-4 py-2 text-center">
                        Tidak ada data riwayat reimbursement sebelumnya.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $reimbursements->links() }}
</div>
