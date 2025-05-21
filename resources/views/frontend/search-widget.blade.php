<div class="widget widget-search">
                                <h3 class="widget-title">Search</h3>
                                <div class="search-box">
                                    <form action="{{ route('website.search') }}" method="GET" class="d-flex">
                                    <input type="text" name="query" class="search-input" placeholder="Search..">
                                    <button type="submit" class="search-button">
                                        <i class="bx bx-search-alt"></i>
                                    </button>
                                    
                                    </form>
                                    
                                 </div>
                                 @error('query')
                                        <span class="error text-danger" style="margin-left:8px;display:block;">{{ $message }}</span>
                                      @enderror
                            </div>