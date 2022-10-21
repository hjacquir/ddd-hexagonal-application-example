<?php

declare(strict_types=1);

namespace App\Application;

use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * We use this custom Response in the case of a paginated list and to encapsulate the recovery of the pagination
 * elements coming from the Symfony\Component\HttpFoundation\Request
 */
class ListResponse
{
    private int $page;
    private int $maxPerPage;
    private string $sort;
    private array $datas;
    private int $code = Response::HTTP_OK;

    public function __construct(Request $request, ValidatorInterface $validator)
    {
        $this->page = $request->query->getInt('page', 1);
        $this->maxPerPage = $request->query->getInt('max_per_page', 5);
        $this->sort = $request->query->getAlpha('sort', 'ASC');

        $contraintViolations = $validator->validate($this);
        // we validate the request parameter here and do not this in the client
        if (count($contraintViolations) > 0) {
            throw new BadRequestException((string) $contraintViolations->get(0)->getMessage());
        }
    }

    public function getDatas(): array
    {
        return $this->datas;
    }

    public function setDatas(array $datas): void
    {
        $this->datas = $datas;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function setCode(int $code): void
    {
        $this->code = $code;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getMaxPerPage(): int
    {
        return $this->maxPerPage;
    }

    public function getSort(): string
    {
        return $this->sort;
    }
}
