<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'What is Shopping Club India?',
                'answer' => '<a href="https://scib2b.com" target="_blank">Shopping Club India</a> is a B2B and retail platform providing premium products across India with business support services, reseller opportunities, and friendly customer service support.',
                'status' => 1,
                'sort_order' => 1,
            ],
            [
                'question' => 'Since when is Shopping Club India operating?',
                'answer' => 'Shopping Club India was started on <span class="highlight-badge">07 May 2016</span> and has been proudly providing stellar services all over India for more than a decade.',
                'status' => 1,
                'sort_order' => 2,
            ],
            [
                'question' => 'Can I start a business with Shopping Club India?',
                'answer' => 'Absolutely! We actively help entrepreneurs, store owners, and resellers start and rapidly grow their own business through our portal and extensive supply chain support system.',
                'status' => 1,
                'sort_order' => 3,
            ],
            [
                'question' => 'What is the minimum order value?',
                'answer' => 'The minimum order value for placing wholesale/B2B purchases through the portal is <span class="highlight-badge">₹2000</span>.',
                'status' => 1,
                'sort_order' => 4,
            ],
            [
                'question' => 'How can I place an order?',
                'answer' => 'You can place orders directly and quickly through our official website or by contacting our dedicated support/sales team directly.',
                'status' => 1,
                'sort_order' => 5,
            ],
            [
                'question' => 'Can I cancel my order?',
                'answer' => 'Yes, orders can be easily cancelled before they are formally accepted and processed by our logistics hub.',
                'status' => 1,
                'sort_order' => 6,
            ],
            [
                'question' => 'How will I receive my refund?',
                'answer' => 'Approved refund amounts are directly credited back to the customer\'s <strong class="text-dark">Wallet</strong> instantly for seamless future purchases.',
                'status' => 1,
                'sort_order' => 7,
            ],
            [
                'question' => 'What happens if the courier returns my parcel?',
                'answer' => 'If a parcel is returned due to courier-side logistics issues, it will be promptly re-dispatched to your address after being received back at the Shopping Club India Hub.',
                'status' => 1,
                'sort_order' => 8,
            ],
            [
                'question' => 'What if the buyer rejects the order?',
                'answer' => 'If the buyer rejects the order, the advance payment percentage will not be refunded.<br>If full payment was made, the advance percentage and actual shipping charges will be deducted, and the remaining balance will be added back to your wallet.',
                'status' => 1,
                'sort_order' => 9,
            ],
            [
                'question' => 'Is there any replacement policy?',
                'answer' => 'Yes, we offer a <span class="highlight-badge">2-day replacement policy</span>. Customers must record a clear, complete, and unedited <strong class="text-dark">unboxing video</strong> to validate replacement claims.',
                'status' => 1,
                'sort_order' => 10,
            ],
            [
                'question' => 'Do you provide delivery across India?',
                'answer' => 'Yes, we provide reliable, fast express delivery services all over India, reaching pin codes far and wide.',
                'status' => 1,
                'sort_order' => 11,
            ],
            [
                'question' => 'Do you have your own courier service?',
                'answer' => 'Yes, Shopping Club India also provides direct <span class="highlight-badge">self courier service support</span> in selected regions and major cities.',
                'status' => 1,
                'sort_order' => 12,
            ],
            [
                'question' => 'Who is the founder of Shopping Club India?',
                'answer' => 'The proud founder of Shopping Club India is <strong class="text-dark">RJ Shiva (Fateh Singh)</strong>.',
                'status' => 1,
                'sort_order' => 13,
            ],
            [
                'question' => 'How can I contact customer support?',
                'answer' => 'You can easily contact our dedicated support team through the official website\'s contact form, email support at <strong class="text-dark">shoppingclubindia1@gmail.com</strong>, phone support at <strong class="text-dark">+91 70882 13888</strong>, or via our official social handles.',
                'status' => 1,
                'sort_order' => 14,
            ]
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
