<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\AuthorRepository;
use App\Repository\BookByAuthorViewRepository;
use App\Utils\AssetsUtils;
use App\Utils\FileUtils;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/report', name: 'app_report_')]
final class ReportController extends AbstractController
{
    #[Route('/generate', name: 'generate', methods: [Request::METHOD_GET])]
    public function generateReportBooksByAuthor(
        BookByAuthorViewRepository $bookByAuthorViewRepository,
        Pdf $pdf,
        AssetsUtils $assets
    ): Response {
        $bookByAuthorsView = $bookByAuthorViewRepository->findAll();

        $booksByAuthors = [];

        foreach ($bookByAuthorsView as $view) {
            $authorId = $view->getAuthorId();
            $bookId = $view->getBookId();

            if (!isset($booksByAuthors[$authorId])) {
                $booksByAuthors[$authorId] = [
                    'authorId' => $authorId,
                    'authorName' => $view->getAuthorName(),
                    'books' => []
                ];
            }

            if (!empty($view->getBookId()) && !isset($booksByAuthors[$authorId]['books'][$bookId])) {
                $booksByAuthors[$authorId]['books'][$bookId] = [
                    'title' => $view->getBookTitle(),
                    'publisher' => $view->getBookPublisher(),
                    'edition' => $view->getBookEdition(),
                    'yearOfPublication' => $view->getBookYearOfPublication(),
                    'price' => $view->getBookPrice(),
                    'subjects' => $view->getSubjectDescription(),
                ];
            }
        }

        $logoDataUri = $assets->getAssetDataUri('build/images/logo/bookhub_logo_1.png');

        $html = $this->renderView('report/_pdf_report_book_by_author_base_template.html.twig', [
            'booksByAuthors' => $booksByAuthors,
            'logoDataUri' => $logoDataUri,
        ]);

        return new Response(
            $pdf->getOutputFromHtml($html),
            Response::HTTP_ACCEPTED,
            [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => FileUtils::fileNamePdfWithDateTime(
                    'relatorio_de_livros_por_autor',
                    true
                ),
            ]
        );
    }
}
