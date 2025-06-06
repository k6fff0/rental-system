@extends('layouts.app')

@section('content')
    <div class="contract-container">
        <div class="contract-header">
            <h1 class="contract-title">{{ __('contract.rental_contract') }}</h1>
            <div class="contract-actions">
                <button id="printBtn" class="btn btn-primary">
                    <i class="fas fa-print"></i> {{ __('contract.print') }}
                </button>
                <button id="exportBtn" class="btn btn-success">
                    <i class="fas fa-file-pdf"></i> {{ __('contract.export_pdf') }}
                </button>
            </div>
        </div>

        <div class="contract-body" id="contractContent">
            <div class="contract-section">
                <div class="contract-parties">
                    <div class="party">
                        <h3>{{ __('contract.first_party') }}</h3>
                        <p>{{ __('contract.property_management') }} - {{ config('app.name') }}</p>
                    </div>
                    <div class="party">
                        <h3>{{ __('contract.second_party') }}</h3>
                        <p>{{ $contract->tenant->name }}
                            @if ($contract->tenant->id_number)
                                <br>{{ __('contract.id_number') }}: {{ $contract->tenant->id_number }}
                            @endif
                            <br>{{ __('contract.phone') }}: {{ $contract->tenant->phone ?? __('contract.not_available') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="divider"></div>

            <div class="contract-section">
                <h2 class="section-title">{{ __('contract.unit_details') }}</h2>
                <div class="unit-details">
                    <div class="detail-item">
                        <span class="detail-label">{{ __('contract.building') }}:</span>
                        <span class="detail-value">{{ $contract->unit->building->name }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">{{ __('contract.unit_number') }}:</span>
                        <span class="detail-value">{{ $contract->unit->unit_number }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">{{ __('contract.floor') }}:</span>
                        <span class="detail-value">{{ $contract->unit->floor ?? __('contract.not_specified') }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">{{ __('contract.unit_type') }}:</span>
                        <span class="detail-value">{{ __('messages.' . $contract->unit->unit_type) }}</span>
                    </div>
                </div>
            </div>

            <div class="divider"></div>

            <div class="contract-section">
                <h2 class="section-title">{{ __('contract.contract_details') }}</h2>
                <div class="contract-details">
                    <div class="detail-item">
                        <span class="detail-label">{{ __('contract.start_date') }}:</span>
                        <span class="detail-value">{{ $contract->start_date }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">{{ __('contract.end_date') }}:</span>
                        <span class="detail-value">{{ $contract->end_date }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">{{ __('contract.rent_amount') }}:</span>
                        <span class="detail-value">{{ number_format($contract->rent_amount) }}
                            {{ __('messages.currency') }}</span>
                    </div>
                </div>
            </div>

            <div class="divider"></div>

            <div class="contract-section">
                <h2 class="section-title">{{ __('contract.terms_conditions') }}</h2>
                <div class="terms-content">
                    {{ old('terms', settings()->default_contract_terms) }}
                </div>
            </div>

            <div class="divider"></div>

            <div class="contract-section">
                <h2 class="section-title">{{ __('contract.signatures') }}</h2>
                <div class="signatures">
                    <div class="signature-block">
                        <div class="signature-line"></div>
                        <p>{{ __('contract.first_party_signature') }}</p>
                    </div>
                    <div class="signature-block">
                        <div class="signature-line"></div>
                        <p>{{ __('contract.second_party_signature') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PDF Export Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --accent-color: #e74c3c;
            --text-color: #333;
            --light-gray: #f5f5f5;
            --border-color: #ddd;
        }

        .contract-container {
            max-width: 900px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: white;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-color);
            direction: rtl;
        }

        .contract-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--primary-color);
        }

        .contract-title {
            color: var(--secondary-color);
            font-size: 1.8rem;
            margin: 0;
        }

        .contract-actions {
            display: flex;
            gap: 1rem;
        }

        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }

        .btn-success {
            background-color: #27ae60;
            color: white;
        }

        .btn-success:hover {
            background-color: #219653;
        }

        .contract-section {
            margin-bottom: 1.5rem;
        }

        .contract-parties {
            display: flex;
            justify-content: space-between;
            gap: 2rem;
        }

        .party {
            flex: 1;
            padding: 1rem;
            background-color: var(--light-gray);
            border-radius: 6px;
        }

        .party h3 {
            color: var(--secondary-color);
            margin-top: 0;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 0.5rem;
        }

        .section-title {
            color: var(--secondary-color);
            font-size: 1.4rem;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .divider {
            height: 1px;
            background-color: var(--border-color);
            margin: 1.5rem 0;
        }

        .unit-details,
        .contract-details {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1rem;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
        }

        .detail-label {
            font-weight: bold;
            color: var(--secondary-color);
            margin-bottom: 0.3rem;
        }

        .terms-content {
            line-height: 1.8;
            text-align: justify;
        }

        .signatures {
            display: flex;
            justify-content: space-around;
            margin-top: 3rem;
        }

        .signature-block {
            text-align: center;
        }

        .signature-line {
            width: 250px;
            height: 1px;
            background-color: var(--text-color);
            margin: 0 auto 0.5rem;
        }

        /* Print Styles */
        @media print {
            .contract-actions {
                display: none;
            }

            .contract-container {
                box-shadow: none;
                padding: 0;
            }
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .contract-parties {
                flex-direction: column;
            }

            .contract-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .unit-details,
            .contract-details {
                grid-template-columns: 1fr;
            }

            .signatures {
                flex-direction: column;
                gap: 2rem;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Print Button
            document.getElementById('printBtn').addEventListener('click', function() {
                window.print();
            });

            // Export to PDF Button
            document.getElementById('exportBtn').addEventListener('click', function() {
                const element = document.getElementById('contractContent');
                const opt = {
                    margin: 10,
                    filename: 'عقد_إيجار_' + new Date().toISOString().slice(0, 10) + '.pdf',
                    image: {
                        type: 'jpeg',
                        quality: 0.98
                    },
                    html2canvas: {
                        scale: 2
                    },
                    jsPDF: {
                        unit: 'mm',
                        format: 'a4',
                        orientation: 'portrait'
                    }
                };

                // Show loading
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري التصدير...';
                this.disabled = true;

                // Generate PDF
                html2pdf().from(element).set(opt).save().then(() => {
                    this.innerHTML = '<i class="fas fa-file-pdf"></i> تصدير PDF';
                    this.disabled = false;
                });
            });
        });
    </script>
@endsection
