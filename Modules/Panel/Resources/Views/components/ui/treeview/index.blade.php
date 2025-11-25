@props([
    'items' => [],
    'levels' => ['tab', 'section', 'other'],
    'selected' => [null, null, null],
])

<div class="treeview-root" role="tree" aria-orientation="vertical" x-data="treeviewComponent(
    @js($items),
    @js($levels),
    @js($selected)
)">
    <template x-for="(item, idx) in tree" :key="item.value">
        <div class="mb-1" role="treeitem">
            <div class="flex w-full items-center gap-x-0.5 py-0.5">
                <template x-if="item.children && item.children.length">
                    <button class="focus:outline-hidden flex size-6 items-center justify-center rounded-md text-xs hover:bg-gray-200 focus:bg-gray-200 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
                            type="button" x-on:click="toggle(item)" :aria-expanded="item.open">
                        <i :class="item.open ? 'bx bx-minus' : 'bx bx-plus'"></i>
                    </button>
                </template>
                <button type="button" class="grow cursor-pointer rounded-md w-full text-left"
                        :class="isSelected(item, 0) ?
                            'bg-primary-100 text-primary-700 dark:bg-primary-900 dark:text-primary-200 font-semibold bg-gray-200 p-1.5' :
                            'p-1.5'"
                        x-on:click="select(item, 0)">
                    <div class="flex items-center gap-x-3">
                        <template x-if="item.icon">
                            <i :class="item.icon + ' size-4 shrink-0 text-gray-500 dark:text-neutral-500'"></i>
                        </template>
                        <template x-if="!item.icon">
                            <i class="bx bx-file size-4 shrink-0 text-gray-400 dark:text-neutral-600"></i>
                        </template>
                        <div class="flex gap-1.5">
                            <span class="text-sm text-gray-800 dark:text-neutral-200" x-text="item.label"></span>
                            <template x-if="item.count !== undefined && item.count !== null">
                                <span class="text-xs text-gray-500 dark:text-neutral-400"
                                      x-text="`(${item.count})`"></span>
                            </template>
                        </div>
                    </div>
                </button>
            </div>
            <template x-if="item.children && item.children.length">
                <div x-show="item.open" class="overflow-hidden" x-cloak>
                    <div
                         class="relative pl-10 before:absolute before:start-3 before:top-0 before:-ms-px before:h-full before:w-0.5 before:bg-gray-200 dark:before:bg-neutral-700">
                        <template x-for="(child, cidx) in item.children" :key="child.value">
                            <div>
                                <div class="mb-1" role="treeitem">
                                    <div class="flex w-full items-center gap-x-0.5 py-0.5">
                                        <template x-if="child.children && child.children.length">
                                            <button class="focus:outline-hidden flex size-6 items-center justify-center rounded-md text-xs hover:bg-gray-200 focus:bg-gray-200 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
                                                    type="button" x-on:click="toggle(child)"
                                                    :aria-expanded="child.open">
                                                <i :class="child.open ? 'bx bx-minus' : 'bx bx-plus'"></i>
                                            </button>
                                        </template>
                                        <button type="button" class="grow cursor-pointer rounded-md w-full text-left"
                                                :class="isSelected(child, 1, [item]) ?
                                                    'bg-primary-100 text-primary-700 dark:bg-primary-900 dark:text-primary-200 font-semibold bg-gray-200 p-1.5' :
                                                    'p-1.5'"
                                                x-on:click="select(child, 1, [item])">
                                            <div class="flex items-center gap-x-3">
                                                <template x-if="child.icon">
                                                    <i
                                                       :class="child.icon +
                                                           ' size-4 shrink-0 text-gray-500 dark:text-neutral-500'"></i>
                                                </template>
                                                <template x-if="!child.icon">
                                                    <i
                                                       class="bx bx-file size-4 shrink-0 text-gray-400 dark:text-neutral-600"></i>
                                                </template>
                                                <div class="flex gap-1.5">
                                                    <span class="text-sm text-gray-800 dark:text-neutral-200"
                                                          x-text="child.label"></span>
                                                    <template x-if="child.count !== undefined && child.count !== null">
                                                        <span class="text-xs text-gray-500 dark:text-neutral-400"
                                                              x-text="`(${child.count})`"></span>
                                                    </template>
                                                </div>
                                            </div>
                                        </button>
                                    </div>
                                    <template x-if="child.children && child.children.length">
                                        <div x-show="child.open" class="overflow-hidden" x-cloak>
                                            <div
                                                 class="relative pl-10 before:absolute before:start-3 before:top-0 before:-ms-px before:h-full before:w-0.5 before:bg-gray-200 dark:before:bg-neutral-700">
                                                <template x-for="(grand, gcidx) in child.children"
                                                          :key="grand.value">
                                                    <div>
                                                        <div class="mb-1" role="treeitem">
                                                            <div class="flex w-full items-center gap-x-0.5 py-0.5">
                                                                <button type="button"
                                                                        class="grow cursor-pointer rounded-md w-full text-left"
                                                                        :class="isSelected(grand, 2, [item, child]) ?
                                                                            'bg-primary-100 text-primary-700 dark:bg-primary-900 dark:text-primary-200 font-semibold bg-gray-200 p-1.5' :
                                                                            'p-1.5'"
                                                                        x-on:click="select(grand, 2, [item, child])">
                                                                    <div class="flex items-center gap-x-3">
                                                                        <template x-if="grand.icon">
                                                                            <i
                                                                               :class="grand.icon +
                                                                                   ' size-4 shrink-0 text-gray-500 dark:text-neutral-500'"></i>
                                                                        </template>
                                                                        <template x-if="!grand.icon">
                                                                            <i
                                                                               class="bx bx-file size-4 shrink-0 text-gray-400 dark:text-neutral-600"></i>
                                                                        </template>
                                                                        <div class="flex gap-1.5">
                                                                            <span class="text-sm text-gray-800 dark:text-neutral-200"
                                                                                  x-text="grand.label"></span>
                                                                            <template
                                                                                      x-if="grand.count !== undefined && grand.count !== null">
                                                                                <span class="text-xs text-gray-500 dark:text-neutral-400"
                                                                                      x-text="`(${grand.count})`"></span>
                                                                            </template>
                                                                        </div>
                                                                    </div>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </template>
        </div>
    </template>
</div>
<script>
    function treeviewComponent(items, levels, selected) {
        // Recursively add open property only if children exist
        function addOpenProp(nodes) {
            return nodes.map(node => ({
                ...node,
                open: false,
                children: node.children && node.children.length ? addOpenProp(node.children) : []
            }));
        }

        return {
            tree: addOpenProp(items),
            selected: selected.slice(0, levels.length),
            levels: levels,

            // Toggle open/close for a node
            toggle(node) {
                node.open = !node.open;
            },

            // Selection logic for any level
            select(node, depth, parents = []) {
                // Build the selected array based on depth and parents
                let newSelected = [];
                for (let i = 0; i < this.levels.length; i++) {
                    if (i < depth) {
                        newSelected[i] = parents[i] ? parents[i].value : null;
                    } else if (i === depth) {
                        newSelected[i] = node.value;
                    } else {
                        newSelected[i] = null;
                    }
                }
                this.selected = newSelected;

                // Set Livewire properties for all levels
                for (let i = 0; i < this.levels.length; i++) {
                    @this.set(this.levels[i], this.selected[i]);
                }
            },

            // Check if a node is selected at a given depth
            isSelected(node, depth, parents = []) {
                for (let i = 0; i < depth; i++) {
                    if (!parents[i] || this.selected[i] !== parents[i].value) {
                        return false;
                    }
                }
                return this.selected[depth] === node.value;
            }
        };
    }
</script>
