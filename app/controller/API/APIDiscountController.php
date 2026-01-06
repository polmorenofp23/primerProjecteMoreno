<?php

require_once DAO_PATH . 'DiscountDAO.php';
require_once UTIL_PATH . 'JsonUtils.php';

class APIDiscountController
{
	/**
     * List all discounts
	 * GET /?controller=api&resource=Discount
	 */
	public function index()
	{
		$dao = new DiscountDAO();
		$discounts = $dao->getAllDiscounts();
		return JsonUtils::jsonResponse(JsonUtils::serializeArray($discounts, 'serializeDiscount', $this));
	}

	/**
     * Retrieve a single discount by ID
	 * GET /?controller=api&resource=Discount&id=123
	 */
	public function show($id)
	{
		$dao = new DiscountDAO();
		$discount = $dao->getDiscountById((int)$id);
		if (!$discount) {
			return JsonUtils::jsonError('Discount not found', ['data' => null], 404);
		}
		return JsonUtils::jsonResponse(JsonUtils::serializeItem($discount, 'serializeDiscount', $this));
	}

	/**
	 * Create a new discount (only user_type discounts)
     * POST /?controller=api&resource=Discount
	 */
	public function store()
	{
		$body = JsonUtils::readJsonBody();
		if ($body === null) {
			return JsonUtils::jsonError('Invalid JSON body', ['data' => null], 400);
		}

		$name = trim((string)($body['name'] ?? ''));
		$percentage = isset($body['percentage']) ? (int)$body['percentage'] : null;
		$userTypeId = isset($body['userTypeId']) ? (int)$body['userTypeId'] : null;
		$description = isset($body['description']) ? trim((string)$body['description']) : null;
		$status = isset($body['status']) ? trim((string)$body['status']) : 'active';

		$errors = [];
		if ($name === '') $errors[] = 'name is required';
		if ($percentage === null) $errors[] = 'percentage is required';
		if ($percentage !== null && ($percentage < 0 || $percentage > 100)) $errors[] = 'percentage must be between 0 and 100';
		if ($userTypeId === null) $errors[] = 'userTypeId is required';
		if (!in_array($status, ['active', 'inactive'], true)) $errors[] = 'status must be active or inactive';

		if (!empty($errors)) {
			return JsonUtils::jsonError('Validation error', ['errors' => $errors], 422);
		}

		$discount = new Discount([
			'name' => $name,
			'description' => $description,
			'percentage' => $percentage,
			'status' => $status,
			'type' => 'user_type',
			'id_user_type' => $userTypeId,
		]);

		$dao = new DiscountDAO();
		$createdId = $dao->createDiscount($discount);
		if (!$createdId) {
			return JsonUtils::jsonError('Failed to create discount', ['data' => null], 500);
		}

		$created = $dao->getDiscountById((int)$createdId);
		return JsonUtils::jsonResponse(JsonUtils::serializeItem($created, 'serializeDiscount', $this), 201);
	}

	/**
     * Update discount percentage, status, and/or userTypeId (user_type discounts)
	 * PUT /?controller=api&resource=Discount&id=123
	 */
	public function update($id)
	{
		$dao = new DiscountDAO();
		$discount = $dao->getDiscountById((int)$id);
		if (!$discount) {
			return JsonUtils::jsonError('Discount not found', ['data' => null], 404);
		}

		$body = JsonUtils::readJsonBody();
		if ($body === null) {
			return JsonUtils::jsonError('Invalid JSON body', ['data' => null], 400);
		}

		$hasChange = false;

		if (array_key_exists('percentage', $body)) {
			$percentage = (int)$body['percentage'];
			if ($percentage < 0 || $percentage > 100) {
				return JsonUtils::jsonError('percentage must be between 0 and 100', ['data' => null], 422);
			}
			$discount->setPercentage($percentage);
			$hasChange = true;
		}

		if (array_key_exists('status', $body)) {
			$status = trim((string)$body['status']);
			if (!in_array($status, ['active', 'inactive'], true)) {
				return JsonUtils::jsonError('status must be active or inactive', ['data' => null], 422);
			}
			$discount->setStatus($status);
			$hasChange = true;
		}

		if (array_key_exists('userTypeId', $body)) {
			$userTypeId = isset($body['userTypeId']) ? (int)$body['userTypeId'] : null;
			if ($userTypeId === null) {
				return JsonUtils::jsonError('userTypeId is required', ['data' => null], 422);
			}
			$discount->setUserTypeId($userTypeId);
			$hasChange = true;
		}

		if (!$hasChange) {
			return JsonUtils::jsonError('No changes provided', ['data' => null], 400);
		}

		$ok = $dao->updateDiscount($discount);
		if (!$ok) {
			return JsonUtils::jsonError('Failed to update discount', ['data' => null], 500);
		}

		$updated = $dao->getDiscountById((int)$id);
		return JsonUtils::jsonResponse(JsonUtils::serializeItem($updated, 'serializeDiscount', $this));
	}

	/**
	 * DELETE /?controller=api&resource=Discount&id=123
	 */
	public function destroy($id)
	{
		$dao = new DiscountDAO();
		$deleted = $dao->deleteDiscount((int)$id);
		if (!$deleted) {
			return JsonUtils::jsonError('Discount not found', ['data' => null], 404);
		}
		return JsonUtils::jsonResponse(['deleted' => true]);
	}

    /* HELPERS */
	/**
     * serialize discount 
     */
	public function serializeDiscount($discount)
	{
		if (!$discount) return null;
		return [
			'id' => $discount->getId(),
			'name' => $discount->getName(),
			'description' => $discount->getDescription(),
			'percentage' => $discount->getPercentage(),
			'status' => $discount->getStatus(),
			'type' => $discount->getType(),
			'discountCode' => $discount->getDiscountCode(),
			'startDatetime' => $discount->getStartDatetime(),
			'endDatetime' => $discount->getEndDatetime(),
			'numReuses' => $discount->getNumReuses(),
			'imgDir' => $discount->getImgDir(),
			'userTypeId' => $discount->getUserTypeId(),
		];
	}
}
