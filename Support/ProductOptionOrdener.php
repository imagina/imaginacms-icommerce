<?php


namespace Modules\Icommerce\Support;

use Modules\Icommerce\Entities\ProductOption;
use Modules\Icommerce\Repositories\ProductOptionRepository;

class ProductOptionOrdener
{

  /**
   * @var ProductOptionRepository
   */
  private $productOptionRepository;

  /**
   * @param MenuItemRepository $productOptionRepository
   */
  public function __construct(ProductOptionRepository $productOptionRepository)
  {
    $this->productOptionRepository = $productOptionRepository;
  }

  /**
   * @param $data
   */
  public function handle($data)
  {
    $data = $this->convertToArray(($data));
    foreach ($data as $position => $item) {
      $this->order($position, $item);
    }

    return true;
  }

  /**
   * Order recursively the menu items
   * @param int   $position
   * @param array $item
   */
  private function order($position, $item)
  {
    $menuItem = $this->productOptionRepository->find($item['id']);

    if (0 === $position && false === true/*$optionValue->isRoot()*/) {
      return;
    }
    $this->savePosition($menuItem, $position);
    $this->makeItemChildOf($menuItem, null);

    if ($this->hasChildren($item)) {
      $this->handleChildrenForParent($menuItem, $item['children']);
    }
  }

  /**
   * @param Menuitem $parent
   * @param array    $children
   */
  private function handleChildrenForParent(/*Menuitem*/ $parent, array $children)
  {
    foreach ($children as $position => $item) {
      $menuItem = $this->productOptionRepository->find($item['id']);
      $this->savePosition($menuItem, $position);
      $this->makeItemChildOf($menuItem, $parent->id);

      if ($this->hasChildren($item)) {
        $this->handleChildrenForParent($menuItem, $item['children']);
      }
    }
  }

  /**
   * Save the given position on the menu item
   * @param object $menuItem
   * @param int    $position
   */
  private function savePosition($menuItem, $position)
  {
    $data = [
      'sort_order' => $position
    ];

    $this->productOptionRepository->update($menuItem, $data);
  }

  /**
   * Check if the product option has children
   *
   * @param  array $item
   * @return bool
   */
  private function hasChildren($item)
  {
    return isset($item['children']);
  }

  /**
   * Set the given parent id on the given product option
   *
   * @param object $item
   * @param int    $parent_id
   */
  private function makeItemChildOf($item, $parent_id)
  {
    $this->productOptionRepository->update($item, compact('parent_id'));
  }

  /**
   * Convert the object to array
   * @param $data
   * @return array
   */
  private function convertToArray($data)
  {
    $data = json_decode(json_encode($data), true);
    return $data;
  }

}