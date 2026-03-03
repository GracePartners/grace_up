
(function(){
  const kanban = document.querySelector('[data-kanban="1"]');
  if(!kanban) return;

  function post(url, data){
    return fetch(url, {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: new URLSearchParams(data).toString()
    }).then(r => r.json().catch(() => ({})));
  }

  kanban.addEventListener('dragstart', (e) => {
    const card = e.target.closest('.kanban__card');
    if(!card) return;
    card.classList.add('dragging');
    e.dataTransfer.setData('text/plain', card.dataset.taskId);
  });

  kanban.addEventListener('dragend', (e) => {
    const card = e.target.closest('.kanban__card');
    if(card) card.classList.remove('dragging');
  });

  kanban.querySelectorAll('.kanban__list').forEach(list => {
    list.addEventListener('dragover', (e) => {
      e.preventDefault();
      list.style.outline = '1px dashed rgba(255,255,255,.25)';
    });
    list.addEventListener('dragleave', () => list.style.outline = 'none');
    list.addEventListener('drop', async (e) => {
      e.preventDefault();
      list.style.outline = 'none';
      const taskId = e.dataTransfer.getData('text/plain');
      if(!taskId) return;

      const card = kanban.querySelector(`.kanban__card[data-task-id="${taskId}"]`);
      if(card) list.appendChild(card);

      const csrf = document.querySelector('input[name="csrf"]')?.value || '';
      const status = list.dataset.status || '';
      await post('/tasks_update_status_ajax.php', {csrf, id: taskId, status});
    });
  });
})();
