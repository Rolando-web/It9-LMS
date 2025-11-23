<x-import>
  <title>Dashboard - Book Management System</title>
</x-import>


  <div class="d-flex min-vh-100 bg-[#1a1b1e]">

    @include('components.sidebar')

    <x-header>
  <h1 class="text-light mb-0 text-2xl md:text-3xl">
       Dashboard
      </h1>
    </x-header>

        <!-- Dashboard Content -->
        <div class="px-8 py-6">
          <!-- Dashboard Filter -->
          <div class="flex justify-end mb-6">
            <div class="flex items-center gap-3">
              <label class="text-gray-400 text-sm font-medium">Dashboard Period:</label>
              <select id="dashboardFilter" class="bg-[#1a1b1e] border border-[#373a40] text-white text-sm rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                <option value="6">Last 6 Months</option>
                <option value="3">Last 3 Months</option>
                <option value="1">This Month</option>
              </select>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-[#2c2e33]  rounded-xl p-6 hover:shadow-xl hover:border-blue-500/50 transition-all duration-300 hover:-translate-y-1">
              <div class="flex items-center justify-between">
                <div class="w-12 h-12 bg-blue-500/10 rounded-xl flex items-center justify-center">
                  <i class="bi bi-book-fill text-blue-500 text-2xl"></i>
                </div>
                <div class="text-right">
                  <p class="text-3xl font-bold text-white mb-1">{{ $totalBooks }}</p>
                  <p class="text-sm text-gray-400 font-medium">Total Books</p>
                </div>
              </div>
            </div>

            <!-- Categories Card -->
            <div class="bg-[#2c2e33]  rounded-xl p-6 hover:shadow-xl hover:border-emerald-500/50 transition-all duration-300 hover:-translate-y-1">
              <div class="flex items-center justify-between">
                <div class="w-12 h-12 bg-emerald-500/10 rounded-xl flex items-center justify-center">
                  <i class="bi bi-tags-fill text-emerald-500 text-2xl"></i>
                </div>
                <div class="text-right">
                  <p class="text-3xl font-bold text-white mb-1">{{ $categoriesCount }}</p>
                  <p class="text-sm text-gray-400 font-medium">Categories</p>
                </div>
              </div>
            </div>

            <!-- Available Copies Card -->
            <div class="bg-[#2c2e33]  rounded-xl p-6 hover:shadow-xl hover:border-purple-500/50 transition-all duration-300 hover:-translate-y-1">
              <div class="flex items-center justify-between">
                <div class="w-12 h-12 bg-purple-500/10 rounded-xl flex items-center justify-center">
                  <i class="bi bi-stack text-purple-500 text-2xl"></i>
                </div>
                <div class="text-right">
                  <p class="text-3xl font-bold text-white mb-1">{{ $availableCopies }}</p>
                  <p class="text-sm text-gray-400 font-medium">Available Copies</p>
                </div>
              </div>
            </div>

            <!-- Authors Card -->
            <div class="bg-[#2c2e33]  rounded-xl p-6 hover:shadow-xl hover:border-orange-500/50 transition-all duration-300 hover:-translate-y-1">
              <div class="flex items-center justify-between">
                <div class="w-12 h-12 bg-orange-500/10 rounded-xl flex items-center justify-center">
                  <i class="bi bi-people-fill text-orange-500 text-2xl"></i>
                </div>
                <div class="text-right">
                  <p class="text-3xl font-bold text-white mb-1">{{ $authorsCount }}</p>
                  <p class="text-sm text-gray-400 font-medium">Authors</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Charts Section -->
          <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-[#2c2e33] rounded-xl shadow-xl p-6">
              <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                  <i class="bi bi-pie-chart text-emerald-500"></i>
                  Return Status
                </h3>
              </div>
              <div class="flex items-center justify-center" style="height: 250px;">
                <canvas id="returnStatusChart"></canvas>
              </div>
              <div class="mt-4 space-y-2">
                <div class="flex items-center justify-between text-sm">
                  <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-emerald-500 rounded-full"></div>
                    <span class="text-gray-400">Returned Well</span>
                  </div>
                  <span class="text-white font-semibold">{{ $returnedWell }}</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                  <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                    <span class="text-gray-400">Damaged</span>
                  </div>
                  <span class="text-white font-semibold">{{ $returnedDamaged }}</span>
                </div>
              </div>
            </div>

            <!-- Total Borrowed Chart -->
            <div class="bg-[#2c2e33] rounded-xl shadow-xl p-6">
              <div class="flex items-center justify-between mb-4">
                <h5 class="font-semibold text-white flex items-center gap-2 md:text-lg">
                  <i class="bi bi-bar-chart text-blue-500"></i>
                  Total Borrowed
                </h5>
                <select id="borrowedFilter" class="bg-[#1a1b1e] border border-[#373a40] text-white text-sm rounded-lg p-1 md:px-3 py-1.5 focus:ring-2 focus:ring-blue-500">
                  <option value="6">Last 6 Months</option>
                  <option value="3">Last 3 Months</option>
                  <option value="1">This Month</option>
                </select>
              </div>
              <div style="height: 250px;">
                <canvas id="borrowedChart"></canvas>
              </div>
            </div>

            <!-- Total Activities Chart -->
            <div class="bg-[#2c2e33] rounded-xl shadow-xl p-6">
              <div class="flex items-center justify-between mb-4">
                <h3 class="md:text-lg font-semibold text-white flex items-center gap-2">
                  <i class="bi bi-activity text-purple-500"></i>
                  Total Activities
                </h3>
                <select id="activitiesFilter" class="bg-[#1a1b1e] border border-[#373a40] text-white text-sm rounded-lg p-1 md:px-3 py-1.5  focus:ring-2 focus:ring-purple-500">
                  <option value="6">Last 6 Months</option>
                  <option value="3">Last 3 Months</option>
                  <option value="1">This Month</option>
                </select>
              </div>
              <div style="height: 250px;">
                <canvas id="activitiesChart"></canvas>
              </div>
            </div>
          </div>

          <!-- Books Table -->
          <div class="bg-[#2c2e33]  rounded-xl shadow-xl overflow-hidden">
            <div class="px-6 py-4 border-b border-[#373a40]">
              <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                  <i class="bi bi-clock-history text-cyan-500"></i>
                  Recently Added Books
                </h3>
                <a href="{{ route('books') }}" class="text-sm text-cyan-500 hover:text-cyan-400 transition-colors">
                  View All <i class="bi bi-arrow-right ms-1"></i>
                </a>
              </div>
            </div>

            <div class="overflow-x-auto">
              <table class="w-full">
                <thead class="bg-[#25262b] border-b border-[#373a40]">
                  <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">Book</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">Author</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">Category</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">ISBN</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">Date</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">Copies</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-400">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($recentBooks as $index => $book)
                  <tr class="border-b border-[#373a40] hover:bg-[#25262b] transition-all duration-200 {{ $index % 2 == 0 ? 'bg-[#2c2e33]' : 'bg-[#272931]' }}">
                    <td class="px-6 py-4">
                      <span class="text-white font-semibold text-base">{{ $book->id }}</span>
                    </td>
                    <td class="px-4 py-4">
                      <div class="flex items-center gap-3">
                        @if($book->image)
                          <img src="{{ asset($book->image) }}" alt="{{ $book->title }}" 
                               class="rounded-lg w-12 h-12 object-cover " />
                        @else
                          <div class="flex items-center justify-center bg-[#1a1b1e] rounded-lg w-12 h-12 ">
                            <i class="bi bi-book text-gray-500 text-xl"></i>
                          </div>
                        @endif
                        <div>
                          <div class="text-white font-semibold text-sm">{{ Str::limit($book->title, 30) }}</div>
                          <small class="text-gray-500 text-xs">ID: {{ $book->id }}</small>
                        </div>
                      </div>
                    </td>
                    <td class="px-4 py-4">
                      <span class="text-gray-300 text-sm">{{ $book->author }}</span>
                    </td>
                    <td class="px-4 py-4">
                      <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-blue-500/10 text-blue-500 border-blue-500/20">
                        <i class="bi bi-tag-fill me-1.5"></i>{{ $book->category }}
                      </span>
                    </td>
                    <td class="px-4 py-4">
                      <span class="text-gray-400 text-sm font-mono">{{ $book->isbn }}</span>
                    </td>
                    <td class="px-4 py-4">
                      <div class="text-gray-300 text-sm">{{ \Carbon\Carbon::parse($book->publish_date)->format('M d, Y') }}</div>
                      <small class="text-gray-500 text-xs">{{ $book->created_at->diffForHumans() }}</small>
                    </td>
                    <td class="px-4 py-4">
                      <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold bg-emerald-500/10 text-emerald-500 border-emerald-500/20">
                        <i class="bi bi-stack me-1.5"></i>{{ $book->copies }}
                      </span>
                    </td>
                    
                    <td class="px-4 py-4 text-end">
                      <div class="flex gap-2 justify-end">
                       <div class="hover:bg-cyan-500/10 hover:border-cyan-500/40 transition-all duration-200 rounded-md">
                         <button class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-transparent  border-cyan-500/20 text-cyan-500 editBtn" 
                                title="Edit Book"
                                data-id="{{ $book->id }}"
                                data-title="{{ $book->title }}"
                                data-author="{{ $book->author }}"
                                data-category="{{ $book->category }}"
                                data-isbn="{{ $book->isbn }}"
                                data-publish_date="{{ $book->publish_date }}"
                                data-copies="{{ $book->copies }}"
                                data-image="{{ $book->image ? asset($book->image) : '' }}"
                                data-bs-toggle="modal"
                                data-bs-target="#editBookModal">
                          <i class="bi bi-pencil-square text-base"></i>
                        </button>
                       </div>
                        <form method="POST" action="{{ route('delete-book', $book->id) }}" class="inline delete-book-form">
                          @csrf
                          @method('DELETE')
                     <div class="hover:bg-red-500/10 hover:border-red-500/40 transition-all duration-200 rounded-md">
                           <button type="submit" class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-transparent  border-red-500/20 text-red-500" 
                                  title="Delete Book">
                            <i class="bi bi-trash text-base"></i>
                          </button>
                     </div>
                        </form>
                      </div>
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="8" class="text-center py-12">
                      <div class="flex flex-col items-center justify-center">
                        <i class="bi bi-inbox text-6xl text-gray-600 mb-4"></i>
                        <h5 class="text-white text-lg font-semibold mb-2">No Books Yet</h5>
                        <p class="text-gray-400 mb-4">Start building your library by adding your first book.</p>
                        <a href="{{ route('books') }}" class="inline-flex items-center px-4 py-2 bg-cyan-500 hover:bg-cyan-600 text-white rounded-lg transition-colors">
                          <i class="bi bi-plus-circle me-2"></i>Add Your First Book
                        </a>
                      </div>
                    </td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            <!-- Pagination -->
            @if($recentBooks->hasPages())
            <div class="px-6 py-4 border-t border-[#373a40] bg-[#25262b] flex items-center justify-between">
              <div class="text-sm text-gray-400">
                Showing <span class="font-semibold text-white">{{ $recentBooks->firstItem() }}-{{ $recentBooks->lastItem() }}</span> of <span class="font-semibold text-white">{{ $recentBooks->total() }}</span> books
              </div>
              <div class="flex items-center gap-2">
                @if ($recentBooks->onFirstPage())
                  <span class="px-3 py-2 rounded-lg bg-[#2c2e33] text-gray-600 cursor-not-allowed"><i class="bi bi-chevron-left"></i></span>
                @else
                  <a href="{{ $recentBooks->previousPageUrl() }}" class="px-3 py-2 rounded-lg bg-[#2c2e33] text-gray-300 hover:text-cyan-500 transition-all"><i class="bi bi-chevron-left"></i></a>
                @endif
                @foreach ($recentBooks->getUrlRange(1, $recentBooks->lastPage()) as $page => $url)
                  @if ($page == $recentBooks->currentPage())
                    <span class="px-4 py-2 rounded-lg bg-cyan-500 text-white font-semibold">{{ $page }}</span>
                  @else
                    <a href="{{ $url }}" class="px-4 py-2 rounded-lg bg-[#2c2e33] text-gray-300 hover:text-white transition-all">{{ $page }}</a>
                  @endif
                @endforeach
                @if ($recentBooks->hasMorePages())
                  <a href="{{ $recentBooks->nextPageUrl() }}" class="px-3 py-2 rounded-lg bg-[#2c2e33] text-gray-300 hover:text-cyan-500 transition-all"><i class="bi bi-chevron-right"></i></a>
                @else
                  <span class="px-3 py-2 rounded-lg bg-[#2c2e33] text-gray-600 cursor-not-allowed"><i class="bi bi-chevron-right"></i></span>
                @endif
              </div>
            </div>
            @endif

          </div>
        </div>
      </main>

      <!-- Include Book Modal Component -->
      <x-book-modal />
      <x-notification-modal/>

      <!-- Bootstrap JS Bundle -->
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="{{ asset('js/book-modal.js') }}"></script>
        <script src="{{ asset('js/sidebar.js') }}"></script>

<script>
// Chart.js Configuration
const borrowedData = @json($borrowedByMonth);
const activitiesData = @json($activitiesByMonth);

// Return Status Pie Chart
const returnStatusCtx = document.getElementById('returnStatusChart').getContext('2d');
const returnStatusChart = new Chart(returnStatusCtx, {
    type: 'doughnut',
    data: {
        labels: ['Returned Well', 'Damaged'],
        datasets: [{
            data: [{{ $returnedWell }}, {{ $returnedDamaged }}],
            backgroundColor: ['#10b981', '#ef4444'],
            borderColor: ['#059669', '#dc2626'],
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor: '#1a1b1e',
                titleColor: '#fff',
                bodyColor: '#fff',
                borderColor: '#373a40',
                borderWidth: 1
            }
        }
    }
});

// Total Borrowed Line Chart
const borrowedCtx = document.getElementById('borrowedChart').getContext('2d');
let borrowedChart = new Chart(borrowedCtx, {
    type: 'line',
    data: {
        labels: borrowedData.map(d => d.month),
        datasets: [{
            label: 'Books Borrowed',
            data: borrowedData.map(d => d.count),
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            borderColor: '#3b82f6',
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#3b82f6',
            pointBorderColor: '#1e3a8a',
            pointBorderWidth: 2,
            pointRadius: 5,
            pointHoverRadius: 7
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor: '#1a1b1e',
                titleColor: '#fff',
                bodyColor: '#fff',
                borderColor: '#373a40',
                borderWidth: 1
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    color: '#9ca3af',
                    stepSize: 1
                },
                grid: {
                    color: '#373a40'
                }
            },
            x: {
                ticks: {
                    color: '#9ca3af'
                },
                grid: {
                    color: '#373a40'
                }
            }
        }
    }
});

// Total Activities Line Chart
const activitiesCtx = document.getElementById('activitiesChart').getContext('2d');
let activitiesChart = new Chart(activitiesCtx, {
    type: 'line',
    data: {
        labels: activitiesData.map(d => d.month),
        datasets: [{
            label: 'Activities',
            data: activitiesData.map(d => d.count),
            backgroundColor: 'rgba(168, 85, 247, 0.1)',
            borderColor: '#a855f7',
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#a855f7',
            pointBorderColor: '#6b21a8',
            pointBorderWidth: 2,
            pointRadius: 5,
            pointHoverRadius: 7
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor: '#1a1b1e',
                titleColor: '#fff',
                bodyColor: '#fff',
                borderColor: '#373a40',
                borderWidth: 1
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    color: '#9ca3af',
                    stepSize: 1
                },
                grid: {
                    color: '#373a40'
                }
            },
            x: {
                ticks: {
                    color: '#9ca3af'
                },
                grid: {
                    color: '#373a40'
                }
            }
        }
    }
});

// Update charts function
function updateCharts(months) {
    // Update Borrowed Chart
    const filteredBorrowedData = borrowedData.slice(-months);
    borrowedChart.data.labels = filteredBorrowedData.map(d => d.month);
    borrowedChart.data.datasets[0].data = filteredBorrowedData.map(d => d.count);
    borrowedChart.update();
    
    // Update Activities Chart
    const filteredActivitiesData = activitiesData.slice(-months);
    activitiesChart.data.labels = filteredActivitiesData.map(d => d.month);
    activitiesChart.data.datasets[0].data = filteredActivitiesData.map(d => d.count);
    activitiesChart.update();
}

// Main Dashboard Filter (Parent Filter)
document.getElementById('dashboardFilter').addEventListener('change', function(e) {
    const months = parseInt(e.target.value);
    
    document.getElementById('borrowedFilter').value = e.target.value;
    document.getElementById('activitiesFilter').value = e.target.value;
    
    // Update all charts
    updateCharts(months);
});


document.getElementById('borrowedFilter').addEventListener('change', function(e) {
    const months = parseInt(e.target.value);
    const filteredData = borrowedData.slice(-months);
    borrowedChart.data.labels = filteredData.map(d => d.month);
    borrowedChart.data.datasets[0].data = filteredData.map(d => d.count);
    borrowedChart.update();
});

document.getElementById('activitiesFilter').addEventListener('change', function(e) {
    const months = parseInt(e.target.value);
    const filteredData = activitiesData.slice(-months);
    activitiesChart.data.labels = filteredData.map(d => d.month);
    activitiesChart.data.datasets[0].data = filteredData.map(d => d.count);
    activitiesChart.update();
});
</script>

<script>
// Handle delete book confirmation
document.addEventListener('submit', async function(e) {
  if (e.target.classList.contains('delete-book-form')) {
    e.preventDefault();
    const confirmed = await showConfirm(
      'Are you sure you want to delete this book? This action cannot be undone.',
      'Delete Book'
    );
    if (confirmed) {
      e.target.submit();
    }
  }
});
</script>
</body>

</html>